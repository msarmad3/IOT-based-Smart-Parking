import 'package:flutter/material.dart';
import 'package:smart_parking/apiservice.dart';
import 'dart:convert';
import 'package:smart_parking/pages/home.dart';
import 'package:smart_parking/pages/loading.dart';
import 'package:smart_parking/pages/search.dart';

void main() async{

  runApp(MaterialApp(
    debugShowCheckedModeBanner: false,
    initialRoute: '/',
    routes: {
      '/': (context) => Loading(),
      '/home': (context) => Home(),
      '/search': (context) => Search(),
    },
  ));
}







