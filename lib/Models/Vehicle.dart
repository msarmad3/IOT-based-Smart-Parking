// ignore_for_file: file_names, non_constant_identifier_names

class Vehicle {
  // int vehicle_no;
  String number_plate_text;
  String Entry_time;
  String Exit_time;
  String Entry_date;



  Vehicle(
      { required this.number_plate_text, required this.Entry_time, required this.Exit_time,required this.Entry_date});

  factory Vehicle.fromJson(Map<String, dynamic> json) {
    return Vehicle(
        // vehicle_no: int.parse(json['Vehicle_no']),
        number_plate_text: json['number_plate_text'] as String,
        Entry_date: json['Entry_date'] as String,
        Entry_time: json['Entry_time'] as String,
        Exit_time: json['Exit_time'] as String);
  }
}
