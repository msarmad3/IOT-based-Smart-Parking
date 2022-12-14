import 'dart:convert';
import 'getslot_status.dart';

import 'package:http/http.dart' as http;
class APIservice{
  static var client = http.Client();
  static Future<slotstatus?>getstatus()async{
    Map<String, String> requestHeaders = {'Content-Type': 'application/json'};

    var url = Uri.https("lln23kvgkg.execute-api.us-east-1.amazonaws.com","/prod/slots");
    var response = await client.get(url);
    if(response.statusCode == 200){
      var data = jsonDecode(response.body);
      return slotstatus.fromJson(data);
      print(data);
    }
    else{
      return null;
    }

  }
}