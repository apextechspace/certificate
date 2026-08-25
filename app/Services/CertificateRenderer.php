<?php

namespace App\Services;

class CertificateRenderer
{
    /**
     * Render the certificate with dynamic data.
     *
     * @param array $data
     * @param bool $debug
     * @return resource|GdImage gd image resource
     */
    public function render(array $data, bool $debug = false)
    {
        $config = config('certificate');
        
        $imagePath = $config['canvas']['image_path'];
        if (!file_exists($imagePath)) {
            throw new \Exception("Master certificate template not found at: {$imagePath}");
        }

        // Load master template image
        $img = imagecreatefrompng($imagePath);
        if (!$img) {
            throw new \Exception("Failed to load certificate template image.");
        }

        // Set higher quality rendering if possible
        imagealphablending($img, true);
        imagesavealpha($img, true);

        // Render each field
        foreach ($config['fields'] as $key => $field) {
            // Skip disabled fields (like QR code)
            if (isset($field['enabled']) && !$field['enabled']) {
                continue;
            }

            // Get dynamic value or default mock
            $value = $data[$key] ?? '';
            if (empty($value)) {
                continue;
            }

            $this->renderField($img, $key, $value, $field);
        }

        // Draw debug overlay if enabled
        if ($debug) {
            $this->renderDebugOverlay($img, $config, $data);
        }

        return $img;
    }

    /**
     * Render a single certificate field.
     */
    private function renderField($img, string $key, string $text, array $field)
    {
        $fontPath = $field['font_path'];
        if (!file_exists($fontPath)) {
            // Fallback if the configured font is missing
            $fontPath = resource_path('fonts/Georgia.ttf');
        }

        $color = $this->allocateColor($img, $field['color'] ?? '#171717');
        $fontSize = $field['font_size'];
        $alignment = $field['alignment'] ?? 'center';

        if ($key === 'name') {
            // Auto-fit single line text
            $minFontSize = $field['min_font_size'] ?? 60;
            $maxWidth = $field['max_width'];

            while ($fontSize > $minFontSize) {
                $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
                $width = abs($bbox[2] - $bbox[0]);
                if ($width <= $maxWidth) {
                    break;
                }
                $fontSize -= 5;
            }

            $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
            $width = abs($bbox[2] - $bbox[0]);
            $height = abs($bbox[1] - $bbox[7]);

            $x = ($alignment === 'center') ? ($field['x'] - ($width / 2)) : $field['x'];
            $y = $field['y'] - (($bbox[1] + $bbox[7]) / 2);

            imagettftext($img, $fontSize, 0, $x, $y, $color, $fontPath, $text);

        } elseif ($key === 'course') {
            // Strip "Fundamentals of " or "fundamentals of " if it starts with it to prevent duplicate text
            if (stripos($text, 'Fundamentals of ') === 0) {
                $text = substr($text, 16);
            }

            // Auto-fit multiline course title
            $minFontSize = $field['min_font_size'] ?? 50;
            $maxWidth = $field['max_width'];
            $maxLines = $field['max_lines'] ?? 2;
            $lineHeight = $field['line_height'] ?? 120;

            $wrappedLines = [];
            while ($fontSize >= $minFontSize) {
                $wrappedLines = $this->wrapText($text, $fontSize, $fontPath, $maxWidth);
                if (count($wrappedLines) <= $maxLines) {
                    break;
                }
                $fontSize -= 2;
            }

            // Render each wrapped line centered
            $totalLines = count($wrappedLines);
            $startY = $field['y'] - ((($totalLines - 1) * $lineHeight) / 2);

            foreach ($wrappedLines as $index => $lineText) {
                $bbox = imagettfbbox($fontSize, 0, $fontPath, $lineText);
                $width = abs($bbox[2] - $bbox[0]);
                
                $x = ($alignment === 'center') ? ($field['x'] - ($width / 2)) : $field['x'];
                $y = ($startY + ($index * $lineHeight)) - (($bbox[1] + $bbox[7]) / 2);

                imagettftext($img, $fontSize, 0, $x, $y, $color, $fontPath, $lineText);
            }
        } else {
            // General text fields (Date, Certificate ID, etc.)
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
            $width = abs($bbox[2] - $bbox[0]);

            $x = ($alignment === 'center') ? ($field['x'] - ($width / 2)) : $field['x'];
            $y = $field['y'] - (($bbox[1] + $bbox[7]) / 2);

            imagettftext($img, $fontSize, 0, $x, $y, $color, $fontPath, $text);
        }
    }

    /**
     * Wrap text into an array of lines that fit the max width.
     */
    private function wrapText(string $text, float $fontSize, string $fontPath, float $maxWidth): array
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = ($currentLine === '') ? $word : $currentLine . ' ' . $word;
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $testLine);
            $width = abs($bbox[2] - $bbox[0]);

            if ($width > $maxWidth) {
                if ($currentLine !== '') {
                    $lines[] = $currentLine;
                    $currentLine = $word;
                } else {
                    $lines[] = $testLine;
                    $currentLine = '';
                }
            } else {
                $currentLine = $testLine;
            }
        }

        if ($currentLine !== '') {
            $lines[] = $currentLine;
        }

        return $lines;
    }

    /**
     * Draw coordinates and bounding boxes for debugging.
     */
    private function renderDebugOverlay($img, array $config, array $data)
    {
        $canvasWidth = $config['canvas']['width'];
        $canvasHeight = $config['canvas']['height'];

        $red = imagecolorallocate($img, 255, 0, 0);
        $blue = imagecolorallocate($img, 0, 0, 255);
        $green = imagecolorallocate($img, 0, 150, 0);
        $gray = imagecolorallocate($img, 200, 200, 200);
        $black = imagecolorallocate($img, 0, 0, 0);

        // Set line thickness for high-resolution canvas
        imagesetthickness($img, 8);

        // Draw vertical center gridline
        imageline($img, $canvasWidth / 2, 0, $canvasWidth / 2, $canvasHeight, $red);

        $fontPath = resource_path('fonts/Inter-Regular.ttf');

        // Draw bounding boxes for active fields
        foreach ($config['fields'] as $key => $field) {
            if (isset($field['enabled']) && !$field['enabled']) {
                continue;
            }

            $value = $data[$key] ?? '';
            if (empty($value)) {
                continue;
            }

            // Draw field center point
            imagefilledellipse($img, $field['x'], $field['y'], 40, 40, $red);

            // Bounding box dimensions
            $halfW = ($field['max_width'] ?? 2000) / 2;
            $alignment = $field['alignment'] ?? 'center';

            if ($alignment === 'center') {
                $left = $field['x'] - $halfW;
                $right = $field['x'] + $halfW;
            } else {
                $left = $field['x'];
                $right = $field['x'] + ($field['max_width'] ?? 1000);
            }

            // Draw Y-coordinate center line for calibration
            imageline($img, $left, $field['y'], $right, $field['y'], $red);

            $heightEstimate = $field['font_size'] * 1.5;
            $top = $field['y'] - ($heightEstimate / 2);
            $bottom = $field['y'] + ($heightEstimate / 2);

            // Draw max boundary rectangle
            imagerectangle($img, $left, $top, $right, $bottom, $blue);
            imagettftext($img, 45, 0, $left + 20, $top - 30, $blue, $fontPath, "Field: {$key} (max_width: " . ($field['max_width'] ?? 'N/A') . ")");
        }

        // Draw dynamic metadata dashboard in top-left corner
        $panelW = 1200;
        $panelH = 650;
        imagefilledrectangle($img, 50, 50, 50 + $panelW, 50 + $panelH, $gray);
        imagerectangle($img, 50, 50, 50 + $panelW, 50 + $panelH, $black);

        $fontPath = resource_path('fonts/Inter-Regular.ttf');
        $metaText = "UMERA CERTIFICATE CALIBRATION OVERLAY\n" .
                    "Canvas Resolution: {$canvasWidth} x {$canvasHeight} px\n" .
                    "--------------------------------------------\n" .
                    "Name Field: X=" . $config['fields']['name']['x'] . ", Y=" . $config['fields']['name']['y'] . "\n" .
                    "Course Field: X=" . $config['fields']['course']['x'] . ", Y=" . $config['fields']['course']['y'] . "\n" .
                    "Date Field: X=" . $config['fields']['date']['x'] . ", Y=" . $config['fields']['date']['y'] . "\n" .
                    "Cert ID Field: X=" . $config['fields']['certificate_id']['x'] . ", Y=" . $config['fields']['certificate_id']['y'] . "\n" .
                    "QR Code Status: DISABLED\n" .
                    "--------------------------------------------\n" .
                    "Test Candidate: " . ($data['name'] ?? 'None') . "\n" .
                    "Test Course: " . ($data['course'] ?? 'None');

        $lines = explode("\n", $metaText);
        foreach ($lines as $idx => $line) {
            imagettftext($img, 30, 0, 80, 110 + ($idx * 45), $black, $fontPath, $line);
        }
    }

    /**
     * Allocate color from hex string.
     */
    private function allocateColor($img, string $hexColor)
    {
        $hex = ltrim($hexColor, '#');
        if (strlen($hex) === 3) {
            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return imagecolorallocate($img, $r, $g, $b);
    }
}
