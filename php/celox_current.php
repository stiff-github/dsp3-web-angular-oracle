<?php
if ($c = OCILogon("login", "pass", "oracle","AL32UTF8")) {
    $s = OCIParse($c, "select to_char(hm.measuredtime,'hh24:mi') MESTIME,hm.measuredtemp TEMPER, nvl(to_char(hm.measuredoxygen),'-') O2,
nvl(to_char(hm.measuredcarbon),'-') CARB, CASE hm.measuredoxygen when 0 then '-' ELSE nvl(to_char(round((105*(0.4545+0.001574*hm.measuredoxygen)),2)),'-') end AL,
(case hm.measurementtype when 'DM' then 'ПЕЧЬ' when 'BM' then 'КОВШ' when 'EM' then 'CELOX' else ' ' end) TYPE
from heatmeasurement hm, eaf1 h where hm.heatidinternal=h.heatidinternal and hm.measurementtype<>'BM' order by hm.measuredtime");
    oci_execute($s);
    $cnt_row = oci_fetch_all($s, $res);
    $i=0;
    oci_execute($s);
    print("[");
    while (oci_fetch($s)) {
        $i++;
        print("{");
        print("\"mestime\":\"");
        print(oci_result($s, "MESTIME"));
        print("\",");
        print("\"temper\":\"");
        print(oci_result($s, "TEMPER"));
        print("\",");
        print("\"o2\":\"");
        print(oci_result($s, "O2"));
        print("\",");
        print("\"carb\":\"");
        print(oci_result($s, "CARB"));
        print("\",");
        print("\"al\":\"");
        print(oci_result($s, "AL"));
        print("\",");
        print("\"type\":\"");
        print(oci_result($s, "TYPE"));
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