function getMaxValTime(){
		var txtFile = new XMLHttpRequest();

		txtFile.open("GET", dataFile, false);
		txtFile.send('');

		if (txtFile.readyState === 4) {
			console.log("ready to parse");
			if (txtFile.status === 200) {
				console.log("file found");
			  
				lines = txtFile.responseText.split("\n");
				var lineSplit =[] ;
				
					lineSplit.push(lines[lines.length - 1].split(","));
						
				
			  
			return parseFloat(lineSplit[lineSplit.length-1][0]) +parseFloat(lineSplit[lineSplit.length-1][1]) 
			 
			}	
		}
	}