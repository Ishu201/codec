 <!-- row count -->
 $count = $result->num_rows;

 number_format($total,'2','.',',');


 <!-- last entered id -->
 $last_id = $conn->insert_id;

 <!-- execute sql -->
 $sql = "";
 $result = $con->query($sql);
 $row = $result->fetch_array();
  $count = $result->num_rows;


 <script type="text/javascript">
 setTimeout(function(){
   $('#stat').remove();
   var newURL = location.href.split("?")[0];
   window.history.pushState('object', document.title, newURL);
 }, 4000)

 </script>

 <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" name="" value="">
