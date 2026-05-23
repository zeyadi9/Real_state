import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class ApiService {
  // Use 10.0.2.2 for Android Emulator to connect to local Laravel server (localhost)
  // If testing on a real device, replace with your PC's local IP address (e.g., 192.168.1.15)
  static const String baseUrl = 'http://10.0.2.2:8000/api';

  // Helper method to get the saved token
  static Future<String?> getToken() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    return prefs.getString('token');
  }

  // Login
  static Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {'Accept': 'application/json'},
      body: {
        'email': email,
        'password': password,
      },
    );

    if (response.statusCode == 200) {
      var data = jsonDecode(response.body);
      if (data['success']) {
        SharedPreferences prefs = await SharedPreferences.getInstance();
        await prefs.setString('token', data['data']['token']);
        return {'success': true, 'message': 'تم تسجيل الدخول بنجاح'};
      }
    }
    
    return {'success': false, 'message': 'بيانات الدخول غير صحيحة'};
  }

  // Logout
  static Future<bool> logout() async {
    String? token = await getToken();
    if (token != null) {
      await http.post(
        Uri.parse('$baseUrl/logout'),
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );
      SharedPreferences prefs = await SharedPreferences.getInstance();
      await prefs.remove('token');
      return true;
    }
    return false;
  }

  // Get Active Properties
  static Future<List<dynamic>> getActiveProperties() async {
    String? token = await getToken();
    final response = await http.get(
      Uri.parse('$baseUrl/properties'),
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    if (response.statusCode == 200) {
      var data = jsonDecode(response.body);
      return data['data']['data']; // Laravel pagination returns data inside data
    }
    return [];
  }

  // Get Sold Properties
  static Future<List<dynamic>> getSoldProperties() async {
    String? token = await getToken();
    final response = await http.get(
      Uri.parse('$baseUrl/properties/sold'),
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    if (response.statusCode == 200) {
      var data = jsonDecode(response.body);
      return data['data']['data'];
    }
    return [];
  }

  // Get Property Details
  static Future<Map<String, dynamic>?> getPropertyDetails(int id) async {
    String? token = await getToken();
    final response = await http.get(
      Uri.parse('$baseUrl/properties/$id'),
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    if (response.statusCode == 200) {
      var data = jsonDecode(response.body);
      return data['data'];
    }
    return null;
  }
}
