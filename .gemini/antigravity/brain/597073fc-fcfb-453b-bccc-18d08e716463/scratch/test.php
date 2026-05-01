<?php

$w = ['wifi'=>0.3, 'harga'=>-0.25, 'bangunan'=>-0.17, 'luas'=>0.15, 'jarak'=>0.13];
$cafe1 = ['wifi'=>0.8, 'harga'=>0.5, 'bangunan'=>0.7, 'luas'=>0.9, 'jarak'=>0.8];
$cafe2 = ['wifi'=>0.9, 'harga'=>0.4, 'bangunan'=>0.6, 'luas'=>0.8, 'jarak'=>0.6];

$s1 = pow($cafe1['wifi'], $w['wifi']) * pow($cafe1['harga'], $w['harga']) * pow($cafe1['bangunan'], $w['bangunan']) * pow($cafe1['luas'], $w['luas']) * pow($cafe1['jarak'], $w['jarak']);
$s2 = pow($cafe2['wifi'], $w['wifi']) * pow($cafe2['harga'], $w['harga']) * pow($cafe2['bangunan'], $w['bangunan']) * pow($cafe2['luas'], $w['luas']) * pow($cafe2['jarak'], $w['jarak']);

echo "S1: $s1\nS2: $s2\n";
echo "V1: " . ($s1/($s1+$s2)) . "\nV2: " . ($s2/($s1+$s2)) . "\n";
