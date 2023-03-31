<div class="card mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-md">
                <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Type here for search">
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md">
                <div class="table-responsive">
                    <table class="table caption-top table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee Name</th>
                                <th>Join Date</th>
                                <th>Leave Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // pemanggilan function ini (loadData()) harus berisi parameter 'btn-edit' dan 'btn-delete' : example : loadData('btn-edit', 'btn-delete') untuk mengaktifkan function getButtons(...args)
    let loadData = () => {
        let tableBody = document.querySelector('tbody');
        tableBody.innerHTML = '';
        
        let request = new XMLHttpRequest();
        request.open('GET', '<?= BASEURL ?>/leave/getAll');
        request.onreadystatechange = () => {
            if(request.readyState == 4 && request.status == 200) {
                let results = JSON.parse(request.responseText);
                let no = 1;
                results.forEach((result) => {
                    let tr = document.createElement('tr');
                    let td1 = document.createElement('td');
                    let td2 = document.createElement('td');
                    let td3 = document.createElement('td');
                    let td4 = document.createElement('td');

                    td1.innerHTML = no++;
                    td2.innerHTML = result.emp_name;
                    td3.innerHTML = result.join_date;
                    td4.innerHTML = result.leave_balance;
                    
                    tr.append(td1);
                    tr.append(td2);
                    tr.append(td3);
                    tr.append(td4);
                    tableBody.append(tr);
                });
            }
        };
        request.send();
    }; loadData();

    // proses search data
    let searchData = () => {
        let tableBody = document.querySelector('tbody');
        tableBody.innerHTML = '';
        
        let keywords = 'keywords=' + document.getElementById('keywords').value;
        let request = new XMLHttpRequest();
        request.open('POST', '<?= BASEURL ?>/leave/search');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.onreadystatechange = () => {
            if(request.readyState == 4 && request.status == 200) {
                let results = JSON.parse(request.responseText);
                let no = 1;
                results.forEach((result) => {
                    let tr = document.createElement('tr');
                    let td1 = document.createElement('td');
                    let td2 = document.createElement('td');
                    let td3 = document.createElement('td');
                    let td4 = document.createElement('td');

                    td1.innerHTML = no++;
                    td2.innerHTML = result.emp_name;
                    td3.innerHTML = result.join_date;
                    td4.innerHTML = result.leave_balance;

                    tr.append(td1);
                    tr.append(td2);
                    tr.append(td3);
                    tr.append(td4);
                    tableBody.append(tr);
                });
            }
        };
        request.send(keywords);
    }; document.getElementById('keywords').addEventListener('keyup', searchData);
    // end proses search data
</script>