<?php
if ($c = OCILogon("login", "pass", "oracle","CL8MSWIN1251")) {
    $s = OCIParse($c, "SELECT injnatgason, injoxyon, carbnatgason, carbcon,
       injnatgaswght, injoxywght, injoxyflwght, carbnatgaswght,
       carboxywght, carbcwght, injnatgaswght1, injnatgaswght2,
       injnatgaswght3, injnatgaswght4, injoxywght1, injoxywght2,
       injoxywght3, injoxywght4, injoxyflwght1, injoxyflwght2,
       injoxyflwght3, injoxyflwght4, carbnatgaswght1,
       carbnatgaswght2, carbnatgaswght3, carboxywght1,
       carboxywght2, carboxywght3, carbcwght1, carbcwght2,
       carbcwght3 FROM level1burners");
    oci_execute($s);
    //print("[");
    while (oci_fetch($s)) {
        print("{");
        print("\"injnatgason\":\"");
        print(oci_result($s, "INJNATGASON"));
        print("\",");
        print("\"injoxyon\":\"");
        print(oci_result($s, "INJOXYON"));
        print("\",");
        print("\"carbnatgason\":\"");
        print(oci_result($s, "CARBNATGASON"));
        print("\",");
        print("\"carbcon\":\"");
        print(oci_result($s, "CARBCON"));
        print("\",");
        print("\"injnatgaswght\":\"");
        print(oci_result($s, "INJNATGASWGHT"));
        print("\",");
        print("\"injoxywght\":\"");
        print(oci_result($s, "INJOXYWGHT"));
        print("\",");
        print("\"injoxyflwght\":\"");
        print(oci_result($s, "INJOXYFLWGHT"));
        print("\",");
        print("\"carbnatgaswght\":\"");
        print(oci_result($s, "CARBNATGASWGHT"));
        print("\",");
        print("\"carboxywght\":\"");
        print(oci_result($s, "CARBOXYWGHT"));
        print("\",");
        print("\"carbcwght\":\"");
        print(oci_result($s, "CARBCWGHT"));
        print("\",");
        print("\"injnatgaswght1\":\"");
        print(oci_result($s, "INJNATGASWGHT1"));
        print("\",");
        print("\"injnatgaswght2\":\"");
        print(oci_result($s, "INJNATGASWGHT2"));
        print("\",");
        print("\"injnatgaswght3\":\"");
        print(oci_result($s, "INJNATGASWGHT3"));
        print("\",");
        print("\"injnatgaswght4\":\"");
        print(oci_result($s, "INJNATGASWGHT4"));
        print("\",");
        print("\"injoxywght1\":\"");
        print(oci_result($s, "INJOXYWGHT1"));
        print("\",");
        print("\"injoxywght2\":\"");
        print(oci_result($s, "INJOXYWGHT2"));
        print("\",");
        print("\"injoxywght3\":\"");
        print(oci_result($s, "INJOXYWGHT3"));
        print("\",");
        print("\"injoxywght4\":\"");
        print(oci_result($s, "INJOXYWGHT4"));
        print("\",");
        print("\"injoxyflwght1\":\"");
        print(oci_result($s, "INJOXYFLWGHT1"));
        print("\",");
        print("\"injoxyflwght2\":\"");
        print(oci_result($s, "INJOXYFLWGHT2"));
        print("\",");
        print("\"injoxyflwght3\":\"");
        print(oci_result($s, "INJOXYFLWGHT3"));
        print("\",");
        print("\"injoxyflwght4\":\"");
        print(oci_result($s, "INJOXYFLWGHT4"));
        print("\",");
        print("\"carbnatgaswght1\":\"");
        print(oci_result($s, "CARBNATGASWGHT1"));
        print("\",");
        print("\"carbnatgaswght2\":\"");
        print(oci_result($s, "CARBNATGASWGHT2"));
        print("\",");
        print("\"carbnatgaswght3\":\"");
        print(oci_result($s, "CARBNATGASWGHT3"));
        print("\",");
        print("\"carboxywght1\":\"");
        print(oci_result($s, "CARBOXYWGHT1"));
        print("\",");
        print("\"carboxywght2\":\"");
        print(oci_result($s, "CARBOXYWGHT2"));
        print("\",");
        print("\"carboxywght3\":\"");
        print(oci_result($s, "CARBOXYWGHT3"));
        print("\",");
        print("\"carbcwght1\":\"");
        print(oci_result($s, "CARBCWGHT1"));
        print("\",");
        print("\"carbcwght2\":\"");
        print(oci_result($s, "CARBCWGHT2"));
        print("\",");
        print("\"carbcwght3\":\"");
        print(oci_result($s, "CARBCWGHT3"));
        print("\"}");
    }
    //print("]");
} else {
    $err = OCIError();
}
?>