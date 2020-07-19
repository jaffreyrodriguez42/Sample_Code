//select the HTML elements that we'll be working with
const addCatBtn = document.querySelector('#addCatBtn');
const catInput = document.querySelector('#catName');
const catSelect = document.querySelector('#category_id');
const addCatNotif = document.querySelector('#addCatNotif');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

addCatBtn.addEventListener('click', ()=>{
	let data = new FormData;
	//append() method of the FormData object takes in 2 arguments:
		//what would be the property name
		//what would be the property value
	data.append('category', catInput.value);

	fetch("/categories", {
		method: "POST",
		body: data,
		//put the CSRF token in the request header
		headers: {
			'X-CSRF-TOKEN': csrfToken
		}
	})
	//when the promise object returned by our fetch request resolves, execute the anonymous function passed in to the then() method:
	.then((res)=>{
		//201 status code signifies successful creation of our category
		if(res.status === 201){
			addCatNotif.setAttribute('class', 'alert alert-success');
		}else{
			addCatNotif.setAttribute('class', 'alert alert-danger');
		}
		return res.json();
	})
	.then((data)=>{
		if(data.data){
			//append the content of the response object's data property to the options under the select element in the products.create view
			catSelect.innerHTML += data.data;
			//console.log(data.data);
		}
		//output the response object's message property in the designated notification element
		addCatNotif.innerHTML = data.message;
	})

})