var customersMap = {
    map: {
        containerId: 'map',
        container: {},
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
    source: {
        url: 'map',
        params: {
            format: 'json',
            limit: 100
        }
    },
    customers: [],
    load: function(){
        var self = this;
        jQuery.getJSON(this.source.url, this.source.params, function(response){
            self.customers = response.customers;
            self.init();
        });
    },
    init: function(){
        var self = this;

        if(this.customers.length==0) return false;

        this.map.options.center = new google.maps.LatLng(this.map.center.lat, this.map.center.lng);

        this.map.container = new google.maps.Map (document.getElementById(this.map.containerId), this.map.options );

        var marker = new google.maps.Marker({
            position: this.map.options.center,
            icon: this.map.icons.center
        });
        marker.setMap(this.map.container);

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
            marker.setMap(this.map.container);
        }
    }
};
