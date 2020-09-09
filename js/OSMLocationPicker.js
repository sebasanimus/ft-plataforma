var OSMPICKER = (function(){
	var app = {};
	
	var marker;
	var circle;
	app.initmappicker = function(lat, lon, map, option){
		
		if(!circle){
			//marker = new L.marker([lat, lon], {draggable:'true'});
			circle = new L.circle([lat, lon], 400, {
				weight: 2
			});
		}else{
			//marker.setLatLng([lat, lon]);
			circle.setLatLng([lat, lon]);
		}
		
		/*marker.on('dragend', function(e){
			circle.setLatLng(e.target.getLatLng());
			map.setView(e.target.getLatLng());
			$("#"+option.latitudeId).val(e.target.getLatLng().lat);
			$("#"+option.longitudeId).val(e.target.getLatLng().lng);
		});*/
		//map.addLayer(marker);
		map.addLayer(circle);

		$("#"+option.latitudeId).val(lat);
		$("#"+option.latitudeId).on('change', function(){
			//marker.setLatLng([Number($(this).val()), marker.getLatLng().lng]);
			circle.setLatLng([Number($(this).val()), circle.getLatLng().lng]);
			map.setView(circle.getLatLng());
		});

		$("#"+option.longitudeId).val(lon);
		$("#"+option.longitudeId).on('change', function(){
			//marker.setLatLng([marker.getLatLng().lat, Number($(this).val())]);
			circle.setLatLng([circle.getLatLng().lat, Number($(this).val())]);
			map.setView(circle.getLatLng());
		});

		$("#"+option.radiusId).val(300);
		$("#"+option.radiusId).on('change', function(){
			circle.setRadius(Number($(this).val()));
		});

		/*$("#"+option.addressId).on('change', function(){
			var item = searchLocation($(this).val(), newLocation);
		});*/
		
		
		/*var osmGeocoder = new L.Control.OSMGeocoder({
			collapsed: false,
			position: 'bottomright',
			text: 'Find!',
		});
		map.addControl(osmGeocoder);*/
		autocompletar(document.getElementById(option.addressId));

		function autocompletar(inp) {
			/*the autocomplete function takes two arguments,
			the text field element and an array of possible autocompleted values:*/

			var currentFocus;
			/*execute a function when someone writes in the text field:*/
			inp.addEventListener("input", function(e) {
				var a, b, i, val = this.value;
				/*close any already open lists of autocompleted values*/
				closeAllLists();
				if (!val || val.length<5) { return false;}
				currentFocus = -1;
				/*create a DIV element that will contain the items (values):*/
				a = document.createElement("DIV");
				a.setAttribute("id", this.id + "autocomplete-list");
				a.setAttribute("class", "autocomplete-items");
				/*append the DIV element as a child of the autocomplete container:*/
				this.parentNode.appendChild(a);
				/*for each item in the array...*/
	
				
				$.ajax({
					url :  "https://nominatim.openstreetmap.org/search?format=json&q="+val,
					type : "GET",
					dataType : 'json',
					error : function(err) {
						console.log(err);
					},
					success : function(arr) {
						for (i = 0; i < arr.length; i++) {
							/*create a DIV element for each matching element:*/
							b = document.createElement("DIV");
							b.innerHTML = arr[i]['display_name'];
							/*insert a input field that will hold the current array item's value:*/
							b.innerHTML += "<input type='hidden' value='" + JSON.stringify(arr[i]) + "'>";
							/*execute a function when someone clicks on the item value (DIV element):*/
							b.addEventListener("click", function(e) {
								/*insert the value for the autocomplete text field:*/
								var item = JSON.parse(this.getElementsByTagName("input")[0].value);
								inp.value = item['display_name'];
								console.log(item)
								newLocation( item);
								/*close the list of autocompleted values,
								(or any other open lists of autocompleted values:*/
								closeAllLists();
							});
							a.appendChild(b);
							
						}
					}
				});
	
	
				
			});

			function newLocation(item){
				$("#"+option.latitudeId).val(item.lat);
				$("#"+option.longitudeId).val(item.lon);
				//marker.setLatLng([item.lat, item.lon]);
				circle.setLatLng([item.lat, item.lon]);
				map.setView([item.lat, item.lon]);
			}
	
			/*execute a function presses a key on the keyboard:*/
			inp.addEventListener("keydown", function(e) {
				var x = document.getElementById(this.id + "autocomplete-list");
				if (x) x = x.getElementsByTagName("div");
				if (e.keyCode == 40) {
					/*If the arrow DOWN key is pressed,
					increase the currentFocus variable:*/
					currentFocus++;
					/*and and make the current item more visible:*/
					addActive(x);
				} else if (e.keyCode == 38) { //up
					/*If the arrow UP key is pressed,
					decrease the currentFocus variable:*/
					currentFocus--;
					/*and and make the current item more visible:*/
					addActive(x);
				} else if (e.keyCode == 13) {
					/*If the ENTER key is pressed, prevent the form from being submitted,*/
					e.preventDefault();
					if (currentFocus > -1) {
						/*and simulate a click on the "active" item:*/
						if (x) x[currentFocus].click();
					}
				}
			});
	
			function addActive(x) {
				/*a function to classify an item as "active":*/
				if (!x) return false;
				/*start by removing the "active" class on all items:*/
				removeActive(x);
				if (currentFocus >= x.length) currentFocus = 0;
				if (currentFocus < 0) currentFocus = (x.length - 1);
				/*add class "autocomplete-active":*/
				x[currentFocus].classList.add("autocomplete-active");
			}
	
			function removeActive(x) {
				/*a function to remove the "active" class from all autocomplete items:*/
				for (var i = 0; i < x.length; i++) {
					x[i].classList.remove("autocomplete-active");
				}
			}
	
			function closeAllLists(elmnt) {
				/*close all autocomplete lists in the document,
				except the one passed as an argument:*/
				var x = document.getElementsByClassName("autocomplete-items");
				for (var i = 0; i < x.length; i++) {
					if (elmnt != x[i] && elmnt != inp) {
						x[i].parentNode.removeChild(x[i]);
					}
				}
			}
			/*execute a function when someone clicks in the document:*/
			document.addEventListener("click", function (e) {
				closeAllLists(e.target);
			});
		}

		
	};

	function searchLocation(text, callback){
		var requestUrl = "http://nominatim.openstreetmap.org/search?format=json&q="+text;
		$.ajax({
			url : requestUrl,
			type : "GET",
			dataType : 'json',
			error : function(err) {
				console.log(err);
			},
			success : function(data) {
				console.log(data);
				var item = data[0];
				callback(item);
			}
		});
	};
	
	return app;
})();
