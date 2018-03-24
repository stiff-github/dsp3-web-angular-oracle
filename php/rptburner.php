<?php
if(isset($_GET['heatend'])) {
    $heatstart = htmlspecialchars($_GET['heatstart']);
    $heatend = htmlspecialchars($_GET['heatend']);
}
if ($c = OCILogon("login", "pass", "oracle","CL8MSWIN1251")) {
    $s = OCIParse($c, "SELECT RTRIM(HEATID) HEATID,INJNATGASWGHT1,INJOXYWGHT1,INJOXYFLWGHT1,INJNATGASWGHT2,INJOXYWGHT2,INJOXYFLWGHT2,
INJNATGASWGHT3,INJOXYWGHT3,INJOXYFLWGHT3,INJNATGASWGHT4,INJOXYWGHT4,INJOXYFLWGHT4,CARBNATGASWGHT1,
CARBOXYWGHT1,CARBCWGHT1,CARBNATGASWGHT2,CARBOXYWGHT2,CARBCWGHT2,CARBNATGASWGHT3,CARBOXYWGHT3,
CARBCWGHT3,nvl(COKEBRLM,0) COKE,nvl(SUMGAS,0) GAS,(nvl(SUM21,0)+nvl(SUM23,0)) O2GOR,nvl(SUM22,0) O2VDUV
FROM V_HEATINJECTION_BURNER VHB, HEATREPORT H WHERE H.HEATIDINTERNAL=VHB.HEATIDINTERNAL
AND (H.HEATID BETWEEN '$heatstart' AND '$heatend') order by HEATID");
    oci_execute($s);
    $cnt_row = oci_fetch_all($s, $res);
    $i=0;
    oci_execute($s);
    print("[");
    while (oci_fetch($s)) {
        $i++;
        print("{");
        print("\"heatid\":\"");
        print(oci_result($s, "HEATID"));
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
        print("\",");
        print("\"coke\":\"");
        print(oci_result($s, "COKE"));
        print("\",");
        print("\"gas\":\"");
        print(oci_result($s, "GAS"));
        print("\",");
        print("\"o2gor\":\"");
        print(oci_result($s, "O2GOR"));
        print("\",");
        print("\"o2vduv\":\"");
        print(oci_result($s, "O2VDUV"));
        if ($cnt_row>$i) {
            print("\"},");
        }
        else {
            print("\"}");
        }
    }
    print("]");
} else {
    $err = OCIError();
}
?>