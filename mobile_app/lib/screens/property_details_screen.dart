import 'package:flutter/material.dart';
import '../api_service.dart';

class PropertyDetailsScreen extends StatefulWidget {
  final int propertyId;

  PropertyDetailsScreen({required this.propertyId});

  @override
  _PropertyDetailsScreenState createState() => _PropertyDetailsScreenState();
}

class _PropertyDetailsScreenState extends State<PropertyDetailsScreen> {
  Map<String, dynamic>? propertyData;
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _fetchDetails();
  }

  void _fetchDetails() async {
    var data = await ApiService.getPropertyDetails(widget.propertyId);
    setState(() {
      propertyData = data;
      isLoading = false;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('تفاصيل العقار'),
        backgroundColor: Colors.blue[800],
        foregroundColor: Colors.white,
      ),
      body: isLoading 
        ? Center(child: CircularProgressIndicator())
        : propertyData == null
          ? Center(child: Text('عفواً، لم يتم العثور على بيانات العقار'))
          : SingleChildScrollView(
              padding: EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  _buildHeaderCard(),
                  SizedBox(height: 16),
                  _buildInfoCard(),
                  SizedBox(height: 16),
                  _buildClientCard(),
                ],
              ),
            ),
    );
  }

  Widget _buildHeaderCard() {
    return Card(
      elevation: 4,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: Container(
        width: double.infinity,
        padding: EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: Colors.blue[50],
          borderRadius: BorderRadius.circular(12),
        ),
        child: Column(
          children: [
            Icon(Icons.apartment, size: 60, color: Colors.blue[800]),
            SizedBox(height: 10),
            Text(
              '${propertyData!['unit_type'] ?? 'عقار'} - ${propertyData!['sale_status'] ?? ''}',
              style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold, color: Colors.blue[900]),
            ),
            Text(
              '${propertyData!['region'] ?? ''} - ${propertyData!['neighborhood'] ?? ''}',
              style: TextStyle(fontSize: 16, color: Colors.grey[700]),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildInfoCard() {
    return Card(
      elevation: 3,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('المواصفات المالية والمكانية', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
            Divider(),
            _buildDetailRow('السعر الإجمالي', '${propertyData!['total_price'] ?? 0} ج.م'),
            _buildDetailRow('المساحة', '${propertyData!['area_sqm'] ?? 0} م²'),
            _buildDetailRow('حالة التشطيب', '${propertyData!['finishing_status'] ?? 'غير محدد'}'),
            _buildDetailRow('عدد الغرف', '${propertyData!['rooms_count'] ?? 0}'),
            _buildDetailRow('الحمامات', '${propertyData!['bathrooms_count'] ?? 0}'),
            _buildDetailRow('الدور', '${propertyData!['floor'] ?? 'غير محدد'}'),
          ],
        ),
      ),
    );
  }

  Widget _buildClientCard() {
    return Card(
      elevation: 3,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('بيانات العميل', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
            Divider(),
            _buildDetailRow('اسم العميل', '${propertyData!['client_name'] ?? 'غير محدد'}'),
            _buildDetailRow('رقم الهاتف', '${propertyData!['client_phone'] ?? 'غير محدد'}'),
          ],
        ),
      ),
    );
  }

  Widget _buildDetailRow(String label, String value) {
    return Padding(
      padding: EdgeInsets.symmetric(vertical: 8),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(label, style: TextStyle(fontWeight: FontWeight.w600, color: Colors.grey[800])),
          Text(value, style: TextStyle(fontWeight: FontWeight.bold, color: Colors.blue[800])),
        ],
      ),
    );
  }
}
