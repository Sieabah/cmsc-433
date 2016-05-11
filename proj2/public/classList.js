/* 
 * ClassNode() is a constructor for the nodes that will be used to traverse the tree and 
 *             check the parents and children of each node. These nodes are used to find
 *             classes that have been taken and which classes can be taken.
 */
function ClassNode(classNumber,children,prereqs){
    // Course number from UMBC
    this.id = classNumber;
    // List of nodes this node is a prerequisite for
    this.children = children;
    // List of nodes that are prerequisites for this node
    this.parents = prereqs;
    // Boolean to keep track of whether or not this class has been taken
    this.taken = false;
}

/*
 * isAvailable() is a function that tells whether or not the class can be taken
 * Input: None
 * Output: true if the class can be taken, false otherwise
 */
ClassNode.prototype.isAvailable = function(){
    for(var i=0, len=this.parents.length; i < len; i++){
	if(this.parents[i].constructor == Array){
	    // counts if there are multiple prereqs that can be used but only one is needed
	    for(var k=0, count=0; k<this.parents[i].length; k++){
		if(this.parents[i][k].taken == true){
		    break;
		}
		count += 1;
	    }
	    if(count == this.parents[i].length){
		return false;  //check this logic, should only occur if we didn't break (before incrementingcount)
	    }
	}
	else if(this.parents[i].taken == false) 
	    return false;
    }
    return true;
    
}
/*
 * markTaken() will flip the boolean from untaken to taken and update all the data for the sidebar
 * Input: None
 * Output: openedClasses - an array of classes that the taken class makes available to take
 */
ClassNode.prototype.markTaken = function(){
    // flips boolean
    this.taken = true;
    // updates lists
    updateCredits(classes[this.id].credits);
    updateWritingIntensive(this.id,"mark");
    updateRequirements(this.id,"mark");
    updateSciRequirements(this.id,"mark");
    updateMathRequirements(this.id,"mark");
    //check which children are made available by taking this class
    var openedClasses = [];
    for(var i=0, len = this.children.length; i < len; i++){
	if(this.children[i].isAvailable()) 
	    openedClasses.push(this.children[i].id);
    }
    return openedClasses;
}
/*
 * clearTaken() will flip the boolean from taken to untaken and update all the data for the sidebar
 * Input: None
 * Output: None
 */
ClassNode.prototype.clearTaken = function(){
    // flips boolean
    this.taken = false;
    // updates lists
    updateCredits(-classes[this.id].credits);
    updateWritingIntensive(this.id,"clear");
    updateRequirements(this.id,"clear");
    updateSciRequirements(this.id,"clear");
    updateMathRequirements(this.id,"clear");
    //recurse through children, clearing any that were marked as taken
    for(var i=0, len = this.children.length; i < len; i++){
	if(this.children[i].taken == true && !this.children[i].isAvailable()){
	    this.children[i].clearTaken();
	}
    }
    return;
}


creditCounter = 0;
requirements = ['201','202','203','304','313','331','341','411','421','441','447'];
notTakenRequirements = ['201','202','203','304','313','331','341','411','421','441','447'];

mathrequirements = ['MATH150', 'MATH151', 'MATH152', 'MATH221', 'STAT355'];
notTakenMathRequirements = ['MATH150', 'MATH151', 'MATH152', 'MATH221', 'STAT355'];

labs = ['CHEM102L', 'PHYS122L', 'GES286', 'BIOL100L', 'SCI101L'];
labsTaken = [];
sciClasses = ['PHYS121', 'PHYS122', 'CHEM101', 'CHEM102', 'BIOL141', 'BIOL142', 'GES110', 'GES120', 'MATH251', 'SCI100'];
sciClassesTaken = [];
 
path1 = ['CHEM101','CHEM102','CHEM102L','GES110'];
path2 = ['CHEM101','CHEM102','BIOL141'];
path3 = ['BIOL141','BIOL142','PHYS121'];
path4 = ['PHYS121','PHYS122','GES286'];
path5 = ['PHYS121','PHYS122','PHYS122L','MATH251'];
path6 = ['SCI100','GES110','GES120','SCI101L'];
scirequirements =  labs.concat(sciClasses);
notTakenSciRequirements =  labs.concat(sciClasses);




labsDone = false;
sciDone = false;
pathReq = false;

function checkRequirements(sci){

	anyLab = false;
	bioLab = labsTaken.indexOf('BIOL100L') > -1 ? true : false;;

	for(var i = 0; i < sci.length; i++){
		anyLab = labsTaken.indexOf(sci[i]) > -1 ? true : false;
		if(anyLab){break;}
	}

	//Path 1
	if((sci.indexOf(path1[0]) > -1 && sci.indexOf(path1[1]) > -1 && sci.indexOf(path1[2]) > -1 && sci.indexOf(path1[3]) > -1)){
		return true;
	}
	else if((sci.indexOf(path2[0]) > -1 && sci.indexOf(path2[1]) > -1 && sci.indexOf(path2[2])) && anyLab){
		return true;
	}
	else if((sci.indexOf(path3[0]) > -1 && sci.indexOf(path3[1]) > -1 && sci.indexOf(path3[2]) > -1 && bioLab)){
		return true;
	}
	else if(sci.indexOf(path4[0]) > -1 && sci.indexOf(path4[1]) > -1 && sci.indexOf(path4[2]) > -1){
		return true;
	}
	else if(sci.indexOf(path5[0]) > -1 && sci.indexOf(path5[1]) > -1 && sci.indexOf(path5[2]) > -1 && sci.indexOf(path5[3]) > -1){
		return true;
	}
	else if(sci.indexOf(path6[0]) > -1 && (sci.indexOf(path6[1]) > -1 || sci.indexOf(path6[2]) > -1) && sci.indexOf(path6[3]) > -1){
		return true;
	}
	return false;
}

/*
 * initializeDependencies() reads the class dictionary from classDictionary.js and uses it to initialize a graph of class Nodes
 * Input: None
 * Output: None
 */
function initializeDependencies(){
	//first create a list of nodes without dependency info
	classNodes = {}; //the class nodes dependency list
	for (var key in classes){
		classNodes[key]=(new ClassNode(key,[],[]));
	}
	//now that all the nodes are created, insert dependency lists
	for (var key in classes){
		var parents = []; //list of prereq nodes
		var children = []; //list of children nodes
		//iterate through the parents in the dictionary and add a pointer to each parent to the node's parents
		for (var i = 0; i < classes[key].parents.length; i++){
			//some of the prereqs can be met by multiple classes; these are represented as arrays instead of single keys
			//any course in that array can satisfy the dependency
			if(classes[key].parents[i].constructor == Array){
				temparr = []
				for (var k = 0; k < classes[key].parents[i].length; k++){
					temparr.push(classNodes[classes[key].parents[i][k]]);
				}
				parents.push(temparr);
			}
			//otherwise, just push a pointer to the parent node itself
			else{
				parents.push(classNodes[classes[key].parents[i]]);
			}
		}
		//push all the children nodes into the children list
		for (var j = 0; j < classes[key].children.length; j++){
			children.push(classNodes[classes[key].children[j]]);
		}
	//assign the collected parents and children to the node
	classNodes[key].parents = parents;
	classNodes[key].children = children;

	}
}

/*
 * clearChecked() clears the check boxes on page load to clear browser memory.
 * Input: None
 * Output: None
 */
function clearChecked(){
	checked = document.getElementsByName('course[]');
	for(var i = 0; i < checked.length; i++){
		checked[i].checked = false;
	}
}


/*
 * reqPrint() returns a string representation of an array or none if empty
 * Input: the array to print
 * Output: an output string representing the array
 */
function reqPrint(arr){
	if (arr.length == 0){
		return "None";
	}
	else{
		return arr.join(', ');
	}
}

/*
 * updateCredits() maintains the global credit counter and updates the html
 * Input: the number of credits (positive or negative) to add to the current count
 * Output: None
 */
function updateCredits(count){
	creditCounter += count; //increment the count
	document.getElementById('takencredits').innerHTML = creditCounter;  //update the display
}
/*
 * updateRequirements() maintains the list of CS requirements that still need to be taken
 * Input: course id; whether the mode is "mark" or "clear" for the update (marking is marking a class as taken)
 * Output: None
 */
function updateRequirements(id,mode){
	id = id.substr(4); //trim the cmsc off the id
	index = requirements.indexOf(id); //check if the id is a cmsc requirement
	//if it is in the requirements list,
	if(index>-1){
		//if we are marking as taken, then remove from the list of outstanding reqs
		if(mode=='mark'){
			notTakenRequirements.splice(notTakenRequirements.indexOf(id),1);
		}
		//otherwise, put it back in the list
		else{
			notTakenRequirements.push(id);
			notTakenRequirements = notTakenRequirements.sort();  //this is not so efficient
		}
		//update the html
		document.getElementById('reqcs').innerHTML = reqPrint(notTakenRequirements);		
	}
	
}
 
/*
 * updateMathRequirements() maintains the list of Math requirements that still need to be taken
 * Input: course id; whether the mode is "mark" or "clear" for the update (marking is marking a class as taken)
 * Output: None
 */
function updateMathRequirements(id,mode){
	id = id.toUpperCase();
	index = mathrequirements.indexOf(id); //check if the id is a cmsc requirement
	//if it is in the requirements list,
	 

	if(index>-1){
		//if we are marking as taken, then remove from the list of outstanding reqs
		if(mode=='mark'){
			notTakenMathRequirements.splice(notTakenMathRequirements.indexOf(id),1);
		}
		//otherwise, put it back in the list
		else{
			notTakenMathRequirements.push(id);
			notTakenMathRequirements = notTakenMathRequirements.sort();  //this is not so efficient
		}
		//update the html
		document.getElementById('reqmath').innerHTML = reqPrint(notTakenMathRequirements);		
	}
	
}
/*
 * updateSciRequirements() maintains the list of Math requirements that still need to be taken
 * Input: course id; whether the mode is "mark" or "clear" for the update (marking is marking a class as taken)
 * Output: None
 */
function updateSciRequirements(id,mode){
	id = id.toUpperCase();
	 
	index = scirequirements.indexOf(id); //check if the id is a cmsc requirement
	//if it is in the requirements list,
	//Checks if the lab requirements are completed
	
	
	//Check paths first

		if(labs.indexOf(id) > -1 && labsTaken.indexOf(id) < 0){
			labsTaken.push(id);
		}
		else if(labs.indexOf(id) > -1 && labsTaken.indexOf(id) > -1){
			labsTaken.splice(labsTaken.indexOf(id),1);
		}
	 
		//Checks if the course requirements are completed.
		if(sciClasses.indexOf(id) > -1 && sciClassesTaken.indexOf(id) < 0){
			sciClassesTaken.push(id);
		}
		else if(sciClasses.indexOf(id) > -1 && sciClassesTaken.indexOf(id) > -1){
			sciClassesTaken.splice(sciClassesTaken.indexOf(id),1);
		}

	
		sci = labsTaken.concat(sciClassesTaken);

	if(index>-1){
		//if we are marking as taken, then remove from the list of outstanding reqs
		if(mode=='mark'){
			notTakenSciRequirements.splice(notTakenSciRequirements.indexOf(id),1);
		}
		//otherwise, put it back in the list
		else{
			notTakenSciRequirements.push(id);	
			notTakenSciRequirements = notTakenSciRequirements.sort();  //this is not so efficient
 		}

		//labsDone = labsTaken.length > 0 ? true : false; 
		//sciDone = sciClassesTaken.length > 1 ? true : false;
		


		//update the html
		if((labsDone && sciDone) || checkRequirements(sci)){
			document.getElementById('reqsci').innerHTML = "Completed";
		}
		else{
			document.getElementById('reqsci').innerHTML = "Not Completed";
		}	
	}
	
}


/*
 * updateWritingIntensive() checks if a course is WI and updates the global variable tracking whether the WI requirement has been satisfied
 * Input: course id, whether marking or clearing
 * Output: None
 */
function updateWritingIntensive(id,mode){
	//only 304 has the writing intensive attribute, so any other class will fail this check
	if(classes[id].writingintensive && classes[id].writingintensive == 'yes'){
		if(mode=="mark"){
				document.getElementById("writingintensive").innerHTML = "Taken";
		}
		else{
				document.getElementById("writingintensive").innerHTML = "Not Taken";
		}
	}
}

/**
* onClick function for class labels, toggles the color and calls the respective helper function to mark class as taken or not
* Input: the element that was clicked
* Output: none
*/
function labelOnClick(element) {
	//if class is not taken yet
	if(element.className == "course"){
		//toggle it to taken
		element.className ="coursetaken";
		//get the course id from the label
		var course = element.id.substr(0,element.id.length-"label".length);
		//go through and enable all the course's children
		restoreClasses(classNodes[course].markTaken());
	}
	//otherwise, the class has already been taken, so toggle it off
	else{
		//set the class to not taken in the html
		element.className ="course";
		//get the course id
		var course = element.id.substr(0,element.id.length-"label".length);
		//recursively clear the class and its descendants
		classNodes[course].clearTaken();
		//update the html display
		updateDisplay();
	}
}

/*
 * labelOnMouseover() is a hover event that displays the relevant course info on the right for the moused-over label
 * Input: None
 * Output: None
 */
function labelOnMouseover(element) {
	try {
		var course = element.id.substr(0, element.id.length - "label".length);
		//show the title
		document.getElementById("coursetitle").innerHTML = classes[course].title;
		//show the credits the course is worth
		document.getElementById("coursecredits").innerHTML = classes[course].credits;
		//show the course description
		document.getElementById("coursedescription").innerHTML = classes[course].description;
	} catch (e){
		//show the title
		document.getElementById("coursetitle").innerHTML = "N/a";
		//show the credits the course is worth
		document.getElementById("coursecredits").innerHTML = "N/a";
		//show the course description
		document.getElementById("coursedescription").innerHTML = "N/a";
	}
}


/*
 * updateDisplay() goes through the classNode data structure and updates all the corresponding html class labels according
 * to whether the classes are available to take or not
 * Input: None
 * Output: None
 */
function updateDisplay() {
	for(var key in classNodes){
		try {
			if (classNodes[key].isAvailable() == false) {
				document.getElementById(key + "label").className = "hiddencourse";
			}
			else if (document.getElementById(key + "label").className == "coursetaken") {
				document.getElementById(key + "label").className = "coursetaken";
			}
			else {
				document.getElementById(key + "label").className = "course";
			}
		} catch(e){
			console.error(e);
			console.error(key);
		}
	}
}

/*
 * hideClasses() takes a list of course ids to hide and hides them in the html
 * Input: list of classes to hide
 * Output: None
 */
function hideClasses(listToHide) {
	for(var i=0, len = listToHide.length; i < len; i++){
		document.getElementById(listToHide[i]+"label").className = "hiddencourse";
	}
}

/*
 * restoreClasses() takes a list of course ids to show and shows them in the html
 * Input: list of classes to show
 * Output: None
 */
function restoreClasses(listToShow) {
	for(var i=0, len=listToShow.length; i < len; i++){
		if(document.getElementById(listToShow[i]+"label").className == "hiddencourse")
			document.getElementById(listToShow[i]+"label").className = "course";
	}
}

initializeDependencies();
updateDisplay();
