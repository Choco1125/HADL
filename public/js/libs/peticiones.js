const consumidor = {
	post: async (contoller,method,formData)=>{
		try{
			let res = await fetch(`${appLinkDomain}/${contoller}/${method}`,{
				method: 'POST',
				body: formData
			});
		
			let data = await res.json();

			return data;
		}catch(err){
			console.error(err);
			return null;
		}
	},
	get: async (contoller,method)=>{
		try{
			let res = await fetch(`${appLinkDomain}/${contoller}/${method}`,{
				method: 'GET'
			});
		
			let data = await res.json();

			return data;
		}catch(err){
			console.error(err);
			return null;
		}
	}
}