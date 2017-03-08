var customersMap = {
    map: {
        container: 'map',
        icons: {
            center: {
                path: google.maps.SymbolPath.CIRCLE,
                fillColor: 'blue',
                fillOpacity: .6,
                scale: 6,
                strokeWeight: 0
            },
            customer: {
                path: google.maps.SymbolPath.CIRCLE,
                fillColor: 'red',
                fillOpacity: .4,
                scale: 4.5,
                strokeColor: 'white',
                strokeWeight: 1
            }
        },
        center: {
            lat: 49.556937,
            lng: 25.637646
        },
        options: {
            zoom: 6
        }
    },
    sourceUrl: 'map?format=json',
    customers: [],
    load: function(){
        var self = this;
        jQuery.getJSON(this.sourceUrl, function(response){
            self.customers = response.customers;
            self.init();
        });
    },
    init: function(){
        if(this.customers.length==0) return false;

        this.map.options.center = new google.maps.LatLng(this.map.center.lat, this.map.center.lng);

        var map = new google.maps.Map (document.getElementById(this.map.container), this.map.options );

        var marker = new google.maps.Marker({
            position: this.map.options.center,
            icon: this.map.icons.center
        });
        marker.setMap(map);

        var i, customer;
        for(i=0; i < this.customers.length; i++) {
            customer = this.customers[i];
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(customer.lat,customer.lng),
                icon: this.map.icons.customer,
                title: " ID: "+customer.id
                + "\n Name: "+customer.name
                + "\n Surname: "+customer.surname
                + "\n City: "+customer.city
                + "\n Adress: "+customer.address
                + "\n PC: "+customer.zip_code
                + "\n Phone: "+customer.phone,
                customerId: customer.id
            });
            marker.setMap(map);
        }
    }
};
