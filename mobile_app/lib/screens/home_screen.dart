import 'package:flutter/material.dart';
import '../api_service.dart';
import 'login_screen.dart';
import 'property_details_screen.dart';

class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> with SingleTickerProviderStateMixin {
  late TabController _tabController;
  List<dynamic> activeProperties = [];
  List<dynamic> soldProperties = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _tabController = TabController(length: 2, vsync: this);
    _fetchData();
  }

  void _fetchData() async {
    setState(() {
      isLoading = true;
    });
    
    var active = await ApiService.getActiveProperties();
    var sold = await ApiService.getSoldProperties();
    
    setState(() {
      activeProperties = active;
      soldProperties = sold;
      isLoading = false;
    });
  }

  void _logout() async {
    await ApiService.logout();
    Navigator.pushReplacement(
      context,
      MaterialPageRoute(builder: (context) => LoginScreen()),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('نظام إدارة العقارات'),
        backgroundColor: Colors.blue[800],
        foregroundColor: Colors.white,
        actions: [
          IconButton(
            icon: Icon(Icons.refresh),
            onPressed: _fetchData,
          ),
          IconButton(
            icon: Icon(Icons.logout),
            onPressed: _logout,
          ),
        ],
        bottom: TabBar(
          controller: _tabController,
          labelColor: Colors.white,
          unselectedLabelColor: Colors.white70,
          tabs: [
            Tab(text: 'متاح للبيع', icon: Icon(Icons.home)),
            Tab(text: 'تم البيع', icon: Icon(Icons.check_circle)),
          ],
        ),
      ),
      body: isLoading 
        ? Center(child: CircularProgressIndicator())
        : TabBarView(
            controller: _tabController,
            children: [
              _buildPropertyList(activeProperties),
              _buildPropertyList(soldProperties),
            ],
          ),
    );
  }

  Widget _buildPropertyList(List<dynamic> properties) {
    if (properties.isEmpty) {
      return Center(child: Text('لا توجد عقارات لعرضها', style: TextStyle(fontSize: 18)));
    }

    return ListView.builder(
      padding: EdgeInsets.all(8),
      itemCount: properties.length,
      itemBuilder: (context, index) {
        var property = properties[index];
        return Card(
          elevation: 3,
          margin: EdgeInsets.symmetric(vertical: 8),
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
          child: ListTile(
            contentPadding: EdgeInsets.all(12),
            leading: CircleAvatar(
              backgroundColor: Colors.blue[100],
              child: Icon(Icons.location_city, color: Colors.blue[800]),
            ),
            title: Text(
              '${property['unit_type'] ?? 'عقار'} - ${property['region'] ?? 'غير محدد'}',
              style: TextStyle(fontWeight: FontWeight.bold),
            ),
            subtitle: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                SizedBox(height: 5),
                Text('السعر: ${property['total_price'] ?? 0} ج.م'),
                Text('المساحة: ${property['area_sqm'] ?? 0} م²'),
              ],
            ),
            trailing: Icon(Icons.arrow_forward_ios, size: 16),
            onTap: () {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) => PropertyDetailsScreen(propertyId: property['id']),
                ),
              );
            },
          ),
        );
      },
    );
  }
}
