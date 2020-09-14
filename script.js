

let p = 1;

function get_page_content(action) {
    if(action == 'next')
        p++;
    else if(action == 'prev')
        p--;
    else
        p = 1;
    
    document.querySelector('#vehicle_container').innerHTML = "<img src='https://upload.wikimedia.org/wikipedia/commons/b/b9/Youtube_loading_symbol_1_(wobbly).gif'></img>";
    
    setTimeout(function(){ 
        
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
    });
    }, 1000);

document.querySelector('button#prev').addEventListener("click", function() { get_page_content('prev'); });
document.querySelector('button#next').addEventListener("click", function() { get_page_content('next'); });
