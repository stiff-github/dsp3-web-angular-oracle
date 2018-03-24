<?php
if ($c = OCILogon("login", "pass", "oracle","CL8MSWIN1251")) {

    $s = OCIParse($c, "select trim(heatid) heatid from heatreport where heatid>0 order by heatid desc");
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
        if ($cnt_row>$i) {
            print("\"},");
        }
        else {
            print("\"}");
        }
    }
    print("]");
} else {
    $err = OCIError(); echo "Oracle OCI Connect Error " . $err[text];
}
?>