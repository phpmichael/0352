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
        url: '',
        params: {
            format: 'json',
            limit: 100
        }
    },
    customers: [],
    load: function(){
        var self = this;
        jQuery.getJSON(self.source.url, self.source.params, function(response){
            self.customers = response.customers;
            self.init();
        });
    },
    init: function(){
        var self = this;

        if(self.customers.length==0) return false;

        self.map.options.center = new google.maps.LatLng(self.map.center.lat, self.map.center.lng);

        self.map.container = new google.maps.Map (document.getElementById(self.map.containerId), self.map.options );

        var marker = new google.maps.Marker({
            position: self.map.options.center,
            icon: self.map.icons.center
        });
        marker.setMap(self.map.container);

        var i, customer;
        for(i=0; i < self.customers.length; i++) {
            customer = self.customers[i];
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(customer.lat,customer.lng),
                icon: self.map.icons.customer,
                title: " ID: "+customer.id
                + "\n Name: "+customer.name
                + "\n Surname: "+customer.surname
                + "\n City: "+customer.city
                + "\n Adress: "+customer.address
                + "\n PC: "+customer.zip_code
                + "\n Phone: "+customer.phone,
                customerId: customer.id
            });
            marker.setMap(self.map.container);

            //create route to customer on click
            google.maps.event.addListener(marker, 'click', function(){
                self.route(this.position.lat(),this.position.lng());
            });
        }

        //init google direction service
        self.directions.service = new google.maps.DirectionsService;
        self.directions.display = new google.maps.DirectionsRenderer;
    },
    directions: {
        service: {},
        display: {}
    },
    route: function(lat, lng){
        var self = this;

        self.directions.display.setMap(self.map.container);

        self.directions.service.route({
            origin: self.map.center.lat+','+self.map.center.lng,
            destination: lat+','+lng,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(response, status) {
            if (status === google.maps.DirectionsStatus.OK) {
                self.directions.display.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }
};
