import 'package:flutter/material.dart';
import 'package:smart_parking/apiservice.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';

import 'package:smart_parking/servies/togetstatus.dart';
class Loading extends StatefulWidget {

  const Loading({Key? key}) : super(key: key);


  @override
  State<Loading> createState() => _LoadingState();
}


class _LoadingState extends State<Loading> {
  String s1 = 'loading';
  void setup() async {
    getSts instance = getSts();
    await instance.getData();
    print(instance.location1);
    Navigator.pushReplacementNamed(context, '/home', arguments: {

    });

  }

  @override
  void initState() {
    super.initState();
    setup();



  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.blue[600],
      body: Center(
        child: SpinKitDoubleBounce(
          color: Colors.white,
          size: 50.0,
        ),

      ),
    );
  }
}
