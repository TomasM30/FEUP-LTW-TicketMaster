let hashtags = [];
let selectedHashtags = [];
let first_time = true;

function autocompleteMatch(input, search_terms) {
    if (input == '') {
        return search_terms;
    }
    let reg = new RegExp(input, 'i');
    return search_terms.filter(function(term) {
        if (term.match(reg)) {
            return term;
        }
    });
}

function showResults(value_to_search) {
    let val = value_to_search[0] == '#' ? value_to_search.substring(1) : value_to_search;
    res = document.getElementById("result");
    res.innerHTML = '';
    let list = '';
    let terms = autocompleteMatch(val, hashtags);

    for (i=0; i< terms.length; i++) {
        if (terms[i] === '')continue;
        list += '<li>#' + terms[i] + '</li>';
        res.style.backgroundColor = "#f5f5f5";
    }

    if (list === '') {
        list += '<li id="noResults">No results found</li>';
        res.style.backgroundColor = "red";
    }

    res.innerHTML = '<ul id="list">' + list + '</ul>';
    let list1 = document.getElementById("list");

    let selectedHashtagsHTML = document.getElementById("selectedHashtags");

    if (list1){
        list1.addEventListener('click', function(e) {
            if (e.target && e.target.matches('li') && !selectedHashtags.includes(e.target.innerHTML) && e.target.innerHTML !== 'No results found') {
                selectedHashtags.push(e.target.innerHTML);
                selectedHashtagsHTML.innerHTML += '<li>' + e.target.innerHTML + '</li>';
            }
        });
    }

    selectedHashtagsHTML.addEventListener('click', function(e) {
        if (e.target && e.target.matches('li')) {
            let index = selectedHashtags.indexOf(e.target.innerHTML);
            selectedHashtags.splice(index, 1);
            e.target.remove();
        }
    }
    );
}

function setHashtags(arr){
    if (first_time){
        hashtags = arr;
        first_time = false;
    }
}

document.getElementById("submit").addEventListener("click", function(){
    let hashtagString = "";
    for (i=0; i<selectedHashtags.length; i++){
        hashtagString += selectedHashtags[i].substring(1) + " ";
    }
    document.getElementById("hashtags").value = hashtagString;
});
