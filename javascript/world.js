var addToWorld=function(){
  var error=0;
  var errorText='';
  if($("#country").val()==''){
    error++;
	errorText="Country\n";
  }
  if($("#city").val()==''){
    error++;
	errorText+="City\n";
  }
  if(error!=0)
    alert("Following fields are required:\n"+errorText);
  else{
    var jsonData={"function":"addToWorld","country":$("#country").val(),"city":$("#city").val()};
	$.ajax({
	  url:"backend/world.php",
	  type:"POST",
	  data:jsonData,
	  dataType:"json",
	  success:function(data){
	    if(data==0) alert("Unsuccessful");
		else{getWorld();}
	  }
	});
  }
};
var getWorld=function(){
  var jsonData={"function":"getWorld"};
  $.ajax({
    url:"backend/world.php",
    type:"POST",
    data:jsonData,
    dataType:"json",
    success:function(data){
	  $("#world").html("");
	  if(data.result.length>0){
	    var data=data.result;
	    $.each(data,function(i,val){
	      var country="<article><h1>"+data[i].Country+"</h1><ul>";
		  $.each(data[i].Cities,function(j,val2){
		    var cities=data[i].Cities[j];
		    country+="<li>"+cities.City+"</li>";
		  });
		  country+="</ul></article>";
		  $("#world").append(country);
	    });
	  }
	  else{
		$("#world").html("No Countries added");  
	  }
    }
  });
}