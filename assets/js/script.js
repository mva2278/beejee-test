document.addEventListener("DOMContentLoaded", () => {
    setLinkHandler();
});
function setLinkHandler(){
    let edit_links = document.querySelectorAll('.edit');
    for(var i=0; i < edit_links.length; i++){
        edit_links[i].addEventListener('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            this.closest('tr').classList.add('active');
        })
    }
    let action_links = document.querySelectorAll('.task');
    for(var i=0; i < action_links.length; i++){
        action_links[i].addEventListener('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            let icon = this.querySelector('i');
            let conf = true;
            if(icon.classList.contains('fa-circle-check')){
                if(!confirm("Вы действительно хотите завершить задачу?")){
                    conf = false;
                }
            }
            if(!conf) return false;
            let data = null;
            if(this.classList.contains('save')){
                let parent = this.closest('tr');
                let desc = parent.querySelector('[name="description"]').value;
                data = new FormData();
                data.append('description', desc);
            }
            let url = this.getAttribute('href');
            fetch(url, {
                method: 'POST',
                body: data,
            })
                .then((response) => response.json())
                .then((data) => {
                    if(!data.access) window.location.href=data.url;
                    if(data.ok) window.location.reload();
            })

        })
    }    
    let action_btn = document.querySelector('[name="action_btn"]');
    if(action_btn !== null){
        action_btn.addEventListener('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            let form = this.closest('form');
            let url = form.getAttribute('action');
            fetch(url, {
                method: 'POST',
                body: new FormData(form),
            })
                .then((response) => response.json())
                .then((data) => {
                    if(data.fail){
                        let fail_el = document.querySelector(data.tag);
                        fail_el.classList.add('bad');
                        document.querySelector('#status-bar').innerHTML = data.mes;
                    }
                    if(data.ok) {
                        if(data.add) form.reset();
                        let answer = document.querySelector('.wrap-answer');
                        answer.style.display = 'block';
                        let wrap_form = document.querySelector('.wrap-form');
                        wrap_form.style.display = 'none';
                    }
            })
        })
    }
    let go_back = document.querySelector('[name="go_back"]');
    if(go_back !== null){
        go_back.addEventListener('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            let url = this.getAttribute('data-link');
            window.location.href = url;
        })
    }   
}
