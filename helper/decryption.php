<?php
class decryption{
    public static function decrypting($encryption)
    {
        // Store the cipher method
        $ciphering = "AES-128-CTR";
        $options = 0;

        // Non-NULL Initialization Vector for decryption
        $decryption_iv = '1234567891011121';
        
        // Store the decryption key
        $decryption_key = "alonburks";
        
        // Use openssl_decrypt() function to decrypt the data
        $decryption=openssl_decrypt ($encryption, $ciphering, 
                $decryption_key, $options, $decryption_iv);
        
        // Display the decrypted string
        return $decryption;
        //echo "Decrypted String: " . $decryption;

    }
}


?>
