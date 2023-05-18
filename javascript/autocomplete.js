let hashtags = [];
let selectedHashtags = [];
let first_time = true;

function autocompleteMatch(input, search_terms) {
    if (input == '') {
        return search_terms;
    }
    let reg = new RegExp(input)
    return search_terms.filter(function(term) {
        if (term.match(reg)) {
            return term;
        }
    });
}

function showResults(val) {
    res = document.getElementById("result");
    res.innerHTML = '';
    let list = '';
    let terms = autocompleteMatch(val, hashtags);

    for (i=0; i< terms.length; i++) {
        if (terms[i] === '')continue;
        list += '<li>#' + terms[i] + '</li>';
    }
    res.innerHTML = '<ul id="list">' + list + '</ul>';
    let list1 = document.getElementById("list");

    let selectedHashtagsHTML = document.getElementById("selectedHashtags");

    if (list1){
        list1.addEventListener('click', function(e) {
            if (e.target && e.target.matches('li') && !selectedHashtags.includes(e.target.innerHTML)) {
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

