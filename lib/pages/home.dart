import 'dart:async';

import 'package:flutter/material.dart';
import 'package:smart_parking/apiservice.dart';
import 'package:smart_parking/servies/togetstatus.dart';
class Home extends StatefulWidget {
  const Home({Key? key}) : super(key: key);

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
  String s1 = '';
  String s2 = '';
  String s3 = '';
  void setup() async {
    getSts instance = getSts();
    await instance.getData();
    setState(() {
      s1 = instance.location1;
      s2 = instance.location2;
      s3 = instance.location3;

    });

  }
  late Timer timer;
  int counter = 0;
  @override
  void initState() {
    super.initState();
    timer = Timer.periodic(Duration(seconds: 3), (Timer t) => setup());
    //setup();




  }



  @override
  Widget build(BuildContext context) {
    Color getTextColor(String text) {

        if (text == 'occupied' ) {
          return Colors.black;
        } else  {
          return Colors.green;
        }
      }
    Color getCardColor(String text) {

      if (text == 'occupied' ) {
        return Colors.red;
      } else  {
        return Colors.black54;
      }
    }


    return Scaffold(
      backgroundColor: Colors.blue[100],
      body: SafeArea(
          child: Padding(
            padding: const EdgeInsets.fromLTRB(0, 120, 0, 0),
            child: Column(
              children: <Widget>[
                TextButton.icon(

                onPressed: (){
                  Navigator.pushNamed(context, '/search');
                },
        icon: Icon(Icons.search),
        label:
        Text('Search Vehicle'),
                ),
                SizedBox(height: 20.0),
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: <Widget>[
                    Card(margin: EdgeInsets.fromLTRB(16.0, 16.0, 16.0, 0),
                      color: getCardColor(s3),
                      child: Text('Slot number 1 is '+s3,
                        style: TextStyle(
                          fontSize: 28.0,
                          letterSpacing: 2.0,
                            color: getTextColor(s3)
                          //backgroundColor: Colors.amber

                        ),
                      ),
                    ),
                  ],
                ),
                SizedBox(height: 20.0),
                Row(

                  mainAxisAlignment: MainAxisAlignment.center,
                  children: <Widget>[
                    Card(margin: EdgeInsets.fromLTRB(16.0, 16.0, 16.0, 0),
                      color: getCardColor(s2),
                      child: Text('Slot number 2 is '+s2,
                        style: TextStyle(
                            fontSize: 28.0,
                            letterSpacing: 2.0,
                            color: getTextColor(s2)
                        ),
                      ),
                    ),
                  ],
                ),
                SizedBox(height: 20.0),
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: <Widget>[
                    Card(margin: EdgeInsets.fromLTRB(16.0, 16.0, 16.0, 0),
                      color: getCardColor(s1),
                      child: Text('Slot number 3 is '+s1,
                        style: TextStyle(
                            fontSize: 28.0,
                            letterSpacing: 2.0,
                            color: getTextColor(s1)
                        ),
                      ),
                    ),
                  ],
                )
              ],
            ),
          ),
      ),
    );
  }
}
