function getEmployeeData () {
    var employee = document.getElementById('employee').value;
    if (employee == 'n/a') {
        return;
    } else {
        var encodedEmployee = encodeURIComponent(employee);
        // Show selected employee name and description
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var jsonObj = JSON.parse(this.responseText);
            document.getElementById('editName').value = jsonObj.??;
            document.getElementById('editPayRate').value = jsonObj.??;
            document.getElementById('editEmailAddress').value = jsonObj.??;
        }
    };
    xhttp.open("GET", "{{ route('dashboard/manage/show') }}/" + encodedEmployee, true);
    xhttp.send();
    }
}
