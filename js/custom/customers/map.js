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
    marker: {
        clickMode: 'route',
        center: {}
    },
    source: {
        url: '',
        params: {
            format: 'json',
            limit: 100,
            routeToClientId: 0
        }
    },
    customers: [],//with have 2 new fields: "position" and "distance"
    load: function(){
        var self = this;

        jQuery.getJSON(self.source.url, self.source.params, function(response){
            self.customers = response.customers;

            if(typeof(response.map.center) !== 'undefined'){
                self.map.center = response.map.center;
            }

            self.init();

            if(typeof(response.routeTo.lat) !== 'undefined' && typeof(response.routeTo.lng) !== 'undefined'){
                self.route(response.routeTo.lat, response.routeTo.lng);
            }
        });
    },
    init: function(){
        var self = this;

        if(self.customers.length==0) return false;

        self.map.options.center = new google.maps.LatLng(self.map.center.lat, self.map.center.lng);

        self.map.container = new google.maps.Map (document.getElementById(self.map.containerId), self.map.options );

        self.marker.center = new google.maps.Marker({
            position: self.map.options.center,
            icon: self.map.icons.center
        });
        self.marker.center.setMap(self.map.container);

        var i, customer, position, marker;
        for(i=0; i < self.customers.length; i++) {
            customer = self.customers[i];
            customer.position = new google.maps.LatLng(customer.lat,customer.lng);
            marker = new google.maps.Marker({
                position: customer.position,
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
                switch (self.marker.clickMode) {
                    case 'route':
                        self.route(this.position.lat(),this.position.lng());
                        break;
                    case 'change-center':
                        //change icon for center marker
                        self.marker.center.setIcon(self.map.icons.customer);

                        //set center icon for current marker
                        this.setIcon(self.map.icons.center);
                        //change center marker to current
                        self.marker.center = this;

                        //change center position to current marker
                        self.map.center.lat = this.position.lat();
                        self.map.center.lng = this.position.lng();

                        //move map center
                        self.map.options.center = new google.maps.LatLng(self.map.center.lat,self.map.center.lng);
                        self.map.container.setCenter(self.map.options.center);
                        break;
                }
            });
        }

        //init google direction service
        self.directions.service = new google.maps.DirectionsService;
        self.directions.display = new google.maps.DirectionsRenderer;

        //get distance to customers
        //self.distanceMatrix();
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
    },
    distanceMatrix: function(){
        var self = this;

        var distanceMatrixService = new google.maps.DistanceMatrixService();
        var limit = 25, destinations = [];

        for(var i=0; i < self.customers.length && i < limit; i++) {
            destinations.push(self.customers[i].position);
        }

        distanceMatrixService.getDistanceMatrix({
            origins: [self.map.options.center],
            destinations: destinations,
            travelMode: google.maps.TravelMode.DRIVING
        }, function (response, status) {
            if(status === 'OK'){
                var i;
                for(i=0; i < response.rows[0].elements.length; i++){
                    self.customers[i].distance = response.rows[0].elements[i].distance.text;
                    console.log(self.customers[i].city+' '+self.customers[i].distance);
                }
            }
            else{
                window.alert('DistanceMatrix request failed due to ' + status);
            }
        });
    }
};
