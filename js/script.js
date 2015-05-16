$(document).ready(function() {
	$("#index").on('click', function() {
		var url = $("#indexurl").val();
		if (url == '') {
			$(".error").addClass("bg-danger text-danger");
			$(".error").html("Please select the url");

		} else {
			$('.error').removeClass("bg-danger text-danger bg-success text-success");
			$('.error').html("Processing ,please wait....");
			$.ajax({
				async : true,
				type : "POST",
				url : "action.php",
				data : "&id=" + url + "&action=index&rand=" + Math.random(),
				dataType : "html",
				success : function(html) {
					if (html == 1) {

						$(".error").addClass("bg-success text-success");
						$(".error").html("Indexing Completed Succesfully");
					} else {

						$(".error").addClass("bg-danger text-danger");
						$(".error").html("Indexing failed");
					}

				}
			});
		}
	});

	$("#indexall").on('click', function() {
		$('.error').removeClass("bg-danger text-danger bg-success text-success");
		$('.error').html("Processing ,please wait....");
		$.ajax({
			async : true,
			type : "POST",
			url : "action.php",
			data : "&action=indexall&rand=" + Math.random(),
			dataType : "html",
			success : function(html) {
				if (html == 1) {

					$(".error").addClass("bg-success text-success");
					$(".error").html("Indexing All site Completed Succesfully");
				} else {

					$(".error").addClass("bg-danger text-danger");
					$(".error").html("Indexing failed");
				}
			}
		});

	});
	$("#indexurl").on('change', function() {
		var url = $("#indexurl").val();
		if (url != '') {
			$(".error").removeClass("bg-danger text-danger bg-success text-success");
			$(".error").html("");

		}
	});
	$("#searchkeyword").on('change', function() {
		var keyword = $("#searchkeyword").val();
		if (keyword != '') {
			$(".error").css("display", "none");

		}
	});
});
var searchapp = angular.module('searchApp', []);
searchapp.controller('SearchController', ['$scope', '$http',
function($scope, $http) {
	$scope.disp = false;
	$scope.error = false;
	$scope.action = "{'action':'search'}";

	$scope.getResult = function() {
		if ( typeof ($scope.searchkeyword) != "undefined") {
			$http({
				method : "POST",
				url : "action.php",
				data : $.param({
					'action' : 'search'
				}),
				headers : {
					'Content-Type' : 'application/x-www-form-urlencoded'
				}
			}).success(function(data) {

				$scope.disp = true;
				$scope.searchresult = data;

			});
		} else {
			$scope.error = true;
		}
	};
	
}]);

