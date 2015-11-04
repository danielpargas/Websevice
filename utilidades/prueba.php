<?php
//imagen png codificada en base64
$Base64Img = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAK8AAACvAQMAAA
				   CxXBw2AAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAWVJREFUSIn
				   Nlr2Vg0AMhMUjIKQEl0Jpx3ZGKS7BIYHfzukPHevDKVolmO85mBWaWRG0Nhrf8
				   2vZMOprpe4wGMuPwMQlf3vT4/kjD64czJJUMAtUzDq3wPyX+UU9YMA7eInXbvC
				   nwKFKn6kDjDqhaawPROB2Tu7EbhKITlx554ul7sYfAr0GYKcFK7V1Jz6UMX4Ap
				   U47e3wNrO80JOOjnoTAGjvxoGknSsJeHtQ8oRyHVQ8gjZbUlMbSnIVhn9wFlkM
				   gD6McAJaaRZ1FWdhm0Dpoc1DJvITyF49p2N4Dh7n16iuemhQTm4Nj+Nwkmpqz53
				   c2HiMHrQKL2Wm0CVVMeVi2MM1BK73qxFKOPcY3SsQ+fC4wYl3aLv2WRxJ2Sc02c
				   74BJZS2PnArUA6z+P4NP9Wagk8bdVTtEOMacyjJzY3I7zRsX/oKq5fUSfnYG3ja
				   qHGEkuw6OdgkNQLP6y3kyqZ/W+9t+BeB6j/x9fcYdwAAAABJRU5ErkJggg==";
 
//eliminamos data:image/png; y base64, de la cadena que tenemos
//hay otras formas de hacerlo				   
list(, $Base64Img) = explode(';', $Base64Img);
list(, $Base64Img) = explode(',', $Base64Img);
//Decodificamos $Base64Img codificada en base64.
$Base64Img = base64_decode($Base64Img);
//escribimos la información obtenida en un archivo llamado 
//unodepiera.png para que se cree la imagen correctamente
file_put_contents('../imagenes/unodepiera.jpg', $Base64Img);	


echo "<img src='unodepiera.jpg' alt='unodepiera' />";
