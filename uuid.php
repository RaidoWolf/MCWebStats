<?php
    function getUUID($usr)
    {
        $ch = curl_init("https://api.mojang.com/profiles/minecraft");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "[\"".$usr."\"]");
        $rlt = curl_exec($ch);
        curl_close($ch);
        $dcd = json_decode($rlt);
        return $dcd[0]->id;
    }
?>
