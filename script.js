

let p = 1;

function get_page_content(action) {
    if(action == 'next')
        p++;
    else if(action == 'prev')
        p--;
    else
        p = 1;
    
    fetch('./pages.php?p=' + p).then(function (response) {
        return response.text();
    }).then(function (html) {
        var parser = new DOMParser();
        var doc = parser.parseFromString(html, 'text/html');
        var content = doc.querySelector("#vehicle_container").innerHTML;
        
        document.querySelector('#vehicle_container').innerHTML = content;
    }).catch(function (err) {
        console.warn('Something went wrong.', err);
    });
}

document.querySelector('button#prev').addEventListener("click", function() { get_page_content('prev'); });
document.querySelector('button#next').addEventListener("click", function() { get_page_content('next'); });
