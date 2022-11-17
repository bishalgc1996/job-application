let searchbar = document.getElementById('myInput');
console.log(searchbar)


function search() {
    var input, filter, tr, td, a, i, txtValue;
    filter = searchbar.value.toUpperCase();
    console.log(filter)

    table = document.getElementById('ja-table');
    tr = table.getElementsByTagName('tr');


    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName('td')[2];
        txtValue = td.textContent || td.innerText;
        console.log(txtValue)

        if (txtValue.toUpperCase().indexOf(filter) > -1) {

            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }


    }

}

function convertDate(d) {
    var p = d.split("-");
    return +(p[2] + p[1] + p[0]);
}


function sortByDate(direction) {
    var tbody = document.querySelector("#ja-table tbody");
    // get trs as array for ease of use
    var rows = [].slice.call(tbody.querySelectorAll("tr"));

    console.log(rows)

    if (direction === 'asc') {
        document.querySelector(".sort-entry").classList.remove('sort-entry--start');
        document.querySelector(".sort-entry").classList.add('sort-entry--end');

        rows.sort(function (a, b) {
            console.log(b.cells[1])
            console.log(a.cells[1])
            return (
                convertDate(b.cells[1].innerHTML) -
                convertDate(a.cells[1].innerHTML)
            );
        });
    } else {
        document.querySelector(".sort-entry").classList.add('sort-entry--start');
        document.querySelector(".sort-entry").classList.remove('sort-entry--end');
        rows.sort(function (a, b) {
            return (
                convertDate(a.cells[1].innerHTML) -
                convertDate(b.cells[1].innerHTML)
            );
        });
    }

    rows.forEach(function (v) {
        tbody.appendChild(v);
    });
}

document.querySelector(".sort-entry").addEventListener("click", () => {
    if (document.querySelector(".sort-entry").classList.contains('sort-entry--start')) {
        document.querySelector(".sort-entry").innerText = "Sort Oldest";

        sortByDate('asc');
    } else {
        document.querySelector(".sort-entry").innerText = "Sort Latest";

        sortByDate('desc');
    }
});