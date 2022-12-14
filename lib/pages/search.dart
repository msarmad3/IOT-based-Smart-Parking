import 'package:flutter/material.dart';
import 'package:smart_parking/Widgets/textField.dart';
import 'package:smart_parking/apiservice.dart';
import 'package:http/http.dart';
import 'dart:convert';
import 'dart:async';

import '../Models/Vehicle.dart';
class Search extends StatefulWidget {
  const Search({Key? key}) : super(key: key);

  @override
  State<Search> createState() => _SearchState();
}

class _SearchState extends State<Search> {

  TextEditingController numberPlateController =  TextEditingController();
Vehicle? vehicle;
Future<List<Vehicle>> generateVehicleList() async {
  // Give your sever URL of get_employees_details.php file
  var url = Uri.https(
      "ubh1oy3eae.execute-api.us-east-1.amazonaws.com", "/prodd");
  Response response = await get(url);
  // print(response.body);
  var list = json.decode(response.body);
  List<Vehicle> vehicles = await list
      .map<Vehicle>((json) => Vehicle.fromJson(json))
      .toList();
  return vehicles;
}
FutureBuilder _getVehiclesData(BuildContext context) {
  return FutureBuilder<List<Vehicle>>(
    future: generateVehicleList(),
    builder:
        (BuildContext context, AsyncSnapshot<List<Vehicle>> snapshot) {
      if (snapshot.hasData) {
        List<Vehicle>? data = snapshot.data;
        int count = data!.length;
        return _floors1(count,data, context);
      } else if (snapshot.hasError) {
        return Text("${snapshot.error}");
      }
      return const CircularProgressIndicator();
    },
  );
}


  Color getCardColor(String text) {

    if (text == '0' ) {
      return Colors.green;
    } else  {
      return Colors.red;
    }
  }
Expanded _floors1(count,data, BuildContext context) {
  return Expanded(
    child: ListView.builder(
        itemCount: count,
        itemBuilder: (context,int index) {
            return Card(margin: EdgeInsets.fromLTRB(16.0, 16.0, 16.0, 0),
                color: getCardColor("${data[index].Exit_time}"),
                child: Text("Vehicle Number: ${data[index].number_plate_text}"
                    "${data[index].Entry_time},"
                    "${data[index].Exit_time},"
                    "${data[index].Entry_date}", style: TextStyle(fontSize: 18),));

        }),
  );
}
Future<Vehicle> getvehicle() async{
  List<Vehicle> vehicles =await generateVehicleList();
  print(vehicles);
  for(int i = 0; i < vehicles.length; i++) {

    if (vehicles[i].number_plate_text == numberPlateController.text) {
      return vehicles[i];
    }
  }
  Vehicle vehicle = Vehicle(number_plate_text: "No Vehicle Found", Entry_time: "No Vehicle Found", Exit_time: "No Vehicle Found", Entry_date: "No Vehicle Found");
    return vehicle;
}

  @override




  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[200],
      appBar: AppBar(
        backgroundColor: Colors.blue[900],
        title: const Text('Search Vehicle'),
        centerTitle: true,
        elevation: 0,
      ),
      body: Padding(
        padding: const EdgeInsets.all(8.0),
        child: Center(
          child: Column(
            children: [

                  TextFieldWidget(controller: numberPlateController, hinttext: "Number Plate"),
                  OutlinedButton(onPressed: ()async{
                    vehicle = await getvehicle();
                    print(vehicle!.number_plate_text);
                    showModalBottomSheet(
                  backgroundColor: Colors.transparent,
                  barrierColor: Colors.transparent,
                  context: context,
                  builder: (_) {
                  return Container(
                  width: double.maxFinite,
                  height: MediaQuery.of(context)
                      .size
                      .height /
                  1.5,
                  decoration: BoxDecoration(
                  color: Colors.blue.shade900
                      .withOpacity(0.5),
                  borderRadius: BorderRadius.only(
                  topLeft: Radius.circular(20),
                  topRight:
                  Radius.circular(20))),
                  child: Padding(
                  padding: const EdgeInsets.only(
                  left: 20, right: 20),
                  child: Column(
                  mainAxisAlignment:
                  MainAxisAlignment.center,
                  children: [
                  Text("Vehicle Number: "+vehicle!.number_plate_text, style: TextStyle(fontSize: 24),),
                  SizedBox(height: 10),
                    Text("Vehicle Entry Time: "+vehicle!.Entry_time, style: TextStyle(fontSize: 24),),
                    Text("Vehicle Entry Date: "+vehicle!.Entry_date, style: TextStyle(fontSize: 24),),
                    Text("Vehicle Exit Time: "+vehicle!.Exit_time, style: TextStyle(fontSize: 24),),
                  ],
                  ),
                  ),
                  );
                  });
                  }, child: Text("Search")),

              SizedBox(height: 10),
              _getVehiclesData(context),
            ],
          )
        ),
      )
    );
  }
}
