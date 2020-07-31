<?php

namespace Slavi122\UpnGenerator;

class UpnGeneratorBih {


	public $payer_address = '';
    public $payer = '';
    public $subject = '';
    public $receiver = '';

	public $code = 'OTHR';

	public $amount = '';
	public $payment_date = '';

	public $reference_prefix = '';
	public $reference = '';

	public $receiver_address = '';
	public $receiver_iban = '';
	public $receiver_bic = '';

	public function generate($output = false) {
		$im = \ImageCreateFromJpeg(__DIR__ . '/upn-blank.jpg');
        $black = imagecolorallocate($im, 0, 6, 195);
        $font = __DIR__ . '/arial.ttf';
        $angle = 0;

        imagefttext($im, 9, $angle, 10, 42, $black, $font, $this->payer);
        imagefttext($im, 9, $angle, 10, 54, $black, $font, $this->payer_address);
        imagefttext($im, 12, $angle, 20, 144, $black, $font, $this->code);
        imagefttext($im, 8, $angle, 120, 114, $black, $font, $this->subject);
  
        $dimensions = imagettfbbox(12, $angle, $font, $this->amount);
        $textWidth = abs($dimensions[4] - $dimensions[0]);
        $x = 212 - $textWidth;
        imagefttext($im, 12, $angle, 370, 110, $black, $font, $this->amount);

        $this->imagettftextSp($im, 12, $angle, 203, 172, $black, $font, $this->payment_date, 4.2);
        imagefttext($im, 12, $angle, 368, 177, $black, $font, $this->receiver_bic);
        $this->imagettftextSp($im, 12, $angle, 335, 75, $black, $font, $this->receiver_iban, 8);
        imagefttext($im, 12, $angle, 17, 244, $black, $font, $this->reference_prefix);
        imagefttext($im, 10, $angle, 10, 78, $black, $font, $this->reference);
        imagefttext($im, 8, $angle, 10, 125, $black, $font, $this->receiver);
        imagefttext($im, 8, $angle, 10, 137, $black, $font, $this->receiver_address);

        if (!$output) { // return string
            ob_start();
            imagejpeg($im);
            $image = ob_get_contents();
            ob_end_clean();

            imagedestroy($im);

            return $image;
        }

        // output the image
        header('Content-Type: image/jpeg');
        imagejpeg($im);
        imagedestroy($im);
    }
    
    public function imagettftextSp($image, $size, $angle, $x, $y, $color, $font, $text, $spacing = 0)
    {
        if ($spacing == 0)
        {
            imagettftext($image, $size, $angle, $x, $y, $color, $font, $text);
        }
        else
        {
            $temp_x = $x;
            for ($i = 0; $i < strlen($text); $i++)
            {
                $bbox = imagettftext($image, $size, $angle, $temp_x, $y, $color, $font, $text[$i]);
                $temp_x += $spacing + ($bbox[2] - $bbox[0]);
            }
        }
    }

}