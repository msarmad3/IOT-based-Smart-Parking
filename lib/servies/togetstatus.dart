import 'package:flutter/material.dart';
import 'package:smart_parking/apiservice.dart';

class getSts{
  String location1 = '';
  String location2 = '';
  String location3 = '';

  getSts();

  Future<void> getData() async{
  try {
    var status = await APIservice.getstatus();
    var str = status!.body.toString();
    List<String> list = [];

    final divisionIndex = str.length ~/ 3;

    for (int i = 0; i < str.length; i++) {
      if (i % divisionIndex == 0) {
        final tempString = str.substring(i, i + divisionIndex);
        list.add(tempString);
      }
    }

    list.remove(',');

    var slot_3 = list.elementAt(0)[35];
    var slot3_status;
    if (slot_3 == 'o') {
      slot3_status = 'occupied';
    } else if (slot_3 == 'a') {
      slot3_status = 'available';
    }
    var slot_2 = list.elementAt(1)[34];
    var slot2_status;
    if (slot_2 == 'o') {
      slot2_status = 'occupied';
    } else if (slot_2 == 'a') {
      slot2_status = 'available';
    }
    var slot_1 = list.elementAt(2)[34];
    var slot1_status;
    if (slot_1 == 'o') {
      slot1_status = 'occupied';
    } else if (slot_1 == 'a') {
      slot1_status = 'available';
    }
    //print(slot1_status);
    //print(slot2_status);
    //print(slot3_status);
    location1 = slot1_status;
    location2 = slot2_status;
    location3 = slot3_status;
  }
  catch(e){
    print('caught error $e');
  }

  }
}

