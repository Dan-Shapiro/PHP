<!DOCTYPE html>
<html>
<script type="text/javascript">

	function processForm(form)
	{
		//first time playing
		var user = document.getElementById("username").value;
		sessionStorage.name = user;

		roundOne(2);
	}
	
	function checkLogin()
	{
		//logged in before
		if(sessionStorage.name)
		{
			roundOne(2);
		}
	}
	
	function roundOne(isDisp)
	{		
		//get the 5 words
		var httpRequest;
		
		if(window.XMLHttpRequest)
		{
			httpRequest = new XMLHttpRequest();
			if(httpRequest.overrideMimeType)
			{
				httpRequest.overrideMimeType('text/xml');
			}
		}
		
		else if(window.ActiveXObject)
		{
			try
			{
				httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e)
			{
				try
				{
					httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch(e)
				{
					
				}
			}
		}
		
		if(!httpRequest)
		{
			alert('Giving up :( Cannot create an XMLHTTP instance');
			return false;
		}
		
		httpRequest.onreadystatechange = function() 
		{ 
			if(httpRequest.readyState == 4)
			{
				if(httpRequest.status == 200)
				{
					//get the 5 words from php output
					var words = httpRequest.responseText;
					sessionStorage.word1 = words.substring(25, 30);
					sessionStorage.word2 = words.substring(30, 35);
					sessionStorage.word3 = words.substring(35, 40);
					sessionStorage.word4 = words.substring(40, 45);
					sessionStorage.word5 = words.substring(45, 50);
				}
				else
				{
					alert('There was a problem with the request.');
				}
			}
		};
		
		httpRequest.open('POST', "getWords.php", true);
		httpRequest.send(null);
		
		//clear page
		document.write('');
		document.close();
		
		//Welcome to Lingo, [name]!
		var title = document.createElement("h1");
		title.style.textAlign = 'center';
		document.body.appendChild(title);
		title.appendChild(document.createTextNode("Welcome to Lingo, "));
		title.appendChild(document.createTextNode(sessionStorage.name));
		title.appendChild(document.createTextNode("!"));
		
		//Round 1
		var round = document.createElement("h2");
		round.id = 'roundNum';
		if(!sessionStorage.roundNum)
		{
			sessionStorage.roundNum = '1';
		}			
		sessionStorage.guessNum = 1;
		round.style.textAlign = 'center';
		document.body.appendChild(round);
		round.appendChild(document.createTextNode("Round " + sessionStorage.roundNum));
		
		//Start round 1 button
		var iDiv = document.createElement('div');
		iDiv.style.textAlign = 'center';
		var iButton = document.createElement('input');
		iButton.type = 'button';
		iButton.value = 'Start Round ' + sessionStorage.roundNum;
		iButton.onclick = function()
		{
			//remove button
			iDiv.removeChild(iButton);
			if(sessionStorage.roundNum != 1)
			{
				//remove the stats and congrats
				document.body.removeChild(d1);
				document.body.removeChild(d2);
				document.body.removeChild(d3);
				document.body.removeChild(d4);
				document.body.removeChild(txt);
			}
			
			//Word Guess:           [Enter]
			iDiv.appendChild(document.createTextNode("Word Guess: "));
			var iGuess = document.createElement('input');
			iGuess.type = 'text';
			iGuess.id = 'guess';
			iDiv.appendChild(iGuess);
			var iButtonGuess = document.createElement('input');
			iButtonGuess.type = 'button';
			iButtonGuess.value = 'Enter';
			iButtonGuess.onclick = submitGuess;
			iDiv.appendChild(iButtonGuess);
			
			//10 second countdown
			startTimer();
			
			//generate blank table (5x5)
			var tbl = document.createElement("table");
			tbl.id = 'myTable';
			tbl.border = 1;
			tbl.align = 'center';
			document.body.appendChild(tbl);
			for(var i = 0; i < 5; i++)
			{
				var hrow = tbl.insertRow(i);
				hrow.align = 'center';
				for(var j = 0; j < 5; j++)
				{
					var c = hrow.insertCell(j);
					c.style.width = '20px';
					var cellContents = document.createTextNode(".");
					c.appendChild(cellContents);
				}
			}
			
			var row = 0;
			var word = sessionStorage.word1;
			sessionStorage.firstLetter = word[0];
			var guess = word[0] + "----";
			populate(row, word, guess);
		};
		iDiv.appendChild(iButton);
		document.body.appendChild(iDiv);
		
		//display stats if not round 1
		if(sessionStorage.roundNum != 1)
		{
			if(isDisp == 0)
			{
				var txt = document.createElement('h3');
				txt.style.textAlign = 'center';
				txt.appendChild(document.createTextNode("Sorry, you lost this round. Play again!"));
				document.body.appendChild(txt);
			}
			else if(isDisp == 1)
			{
				var txt = document.createElement('h3');
				txt.style.textAlign = 'center';
				txt.appendChild(document.createTextNode("Congratulations, you won this round! Play again!"));
				document.body.appendChild(txt);
			}
			
			//stats
			var d1 = document.createElement('div');
			var d2 = document.createElement('div');
			var d3 = document.createElement('div');
			var d4 = document.createElement('div');
			d1.style.textAlign = 'center';
			d2.style.textAlign = 'center';
			d3.style.textAlign = 'center';
			d4.style.textAlign = 'center';
			d1.appendChild(document.createTextNode("Stats"));
			d2.appendChild(document.createTextNode("Total rounds played: " + localStorage.totalRound));
			d3.appendChild(document.createTextNode("Total puzzles played: " + localStorage.totalPlay));
			d4.appendChild(document.createTextNode("Total puzzles won: " + localStorage.totalWins));
			document.body.appendChild(d1);
			document.body.appendChild(d2);
			document.body.appendChild(d3);
			document.body.appendChild(d4);
			}
		
		//set wins at 0 and games played in round at 1
		sessionStorage.roundWins = 0;
		sessionStorage.roundPlay = 1;

		if(localStorage.totalPlay)
		{
			localStorage.totalPlay;
		}
		else
		{
			localStorage.totalPlay = 1;
			localStorage.totalWins = 0;
		}
	}
	
	function populate(row, word, guess)
	{
		var tbl = document.getElementById('myTable');
		
		for(var i = 0; i < 5; i++)
		{
			if(guess[i] == null)
			{
				tbl.rows[row].cells[i].innerHTML = "-";
				tbl.rows[row].cells[i].style.color = 'black';
			}
			else if(word[i] == guess[i])
			{
				tbl.rows[row].cells[i].innerHTML = word[i].toUpperCase();
				tbl.rows[row].cells[i].style.color = 'red';
			}
			else if(guess[i] != word[0] && guess[i] != word[1] && guess[i] != word[2] && guess[i] != word[3] && guess[i] != word[4])
			{
				tbl.rows[row].cells[i].innerHTML = guess[i].toLowerCase();
				tbl.rows[row].cells[i].style.color = 'black';
			}
			else
			{
				tbl.rows[row].cells[i].innerHTML = guess[i].toUpperCase();
				tbl.rows[row].cells[i].style.color = 'blue';
			}
		}
	}
	
	//initialize the countdown
	var timer = document.createElement("p");
	timer.id = 'countdown';
	timer.style.textAlign = 'center';
	sessionStorage.count  = 10;
	var currTime = document.createTextNode(sessionStorage.count);
	timer.appendChild(currTime);
	
	function startTimer()
	{
		//put timer up
		document.body.appendChild(timer);
		
		//decrement every second
		if(sessionStorage.roundNum == 1)
		{
			var timerId = setInterval(function()
			{
				if(sessionStorage.count == 0)
				{
					submitGuess();
				}
				sessionStorage.count--;
				currTime.nodeValue = sessionStorage.count;
			}, 1000);
		}

		//timer starts ticking
		resetTimer();
	}
	
	function resetTimer()
	{
		//reset clock to 10
		sessionStorage.count = 10;		
	}
	
	
	function submitGuess()
	{
		//get the guessed word		
		var iGuess = document.getElementById("guess");
		var guess = iGuess.value;
		iGuess.value = "";
		
		//word must be 5 letter long
		
		var guessNum = sessionStorage.guessNum;
		var rowNum = guessNum - 1;
		
		//put it in the right row
		var word;
		switch(sessionStorage.roundPlay)
		{
			case '1':
				word = sessionStorage.word1;
				break;
			case '2':
				word = sessionStorage.word2;
				break;
			case '3':
				word = sessionStorage.word3;
				break;
			case '4':
				word = sessionStorage.word4;
				break;
			case '5':
				word = sessionStorage.word5;
				break;
			default:
				break;
		}
		
		//current word saved
		sessionStorage.currWord = word;
		
		//word is correct
		if(guess.localeCompare(word) == 0)
		{
			endRoundOne(1);
		}
		
		//show next blank row in table
		populate(rowNum, word, guess);
		if(guessNum < 5)
		{
			var guess = sessionStorage.firstLetter + "----";
			populate(guessNum, word, guess);
			sessionStorage.guessNum++;
			resetTimer();
		}
		//word is wrong
		else
		{
			endRoundOne(0);
		}
	}
	
	function endRoundOne(isWin)
	{	
		//clear page
		document.write('');
		document.close();
		
		//Welcome to Lingo, [name]!
		var title = document.createElement("h1");
		title.style.textAlign = 'center';
		document.body.appendChild(title);
		title.appendChild(document.createTextNode("Welcome to Lingo, "));
		title.appendChild(document.createTextNode(sessionStorage.name));
		title.appendChild(document.createTextNode("!"));
		
		//Round #
		var round = document.createElement("h2");
		round.id = 'roundNum';
		round.style.textAlign = 'center';
		document.body.appendChild(round);
		var disp = "Round " + sessionStorage.roundNum;
		round.appendChild(document.createTextNode(disp));
			
		//button to go to next puzzle
		var buttonDiv = document.createElement('div');
		buttonDiv.style.textAlign = 'center';
		var nextPuzzle = document.createElement('input');
		nextPuzzle.type = 'button';
		nextPuzzle.value = 'Next Puzzle';
		nextPuzzle.onclick = otherPuzzle;
		buttonDiv.appendChild(nextPuzzle);
		document.body.appendChild(buttonDiv);
		
		//create text node to be filled
		var txt = document.createElement("h3");
		txt.style.textAlign = 'center';
		document.body.appendChild(txt);
		
		if(isWin == 1)
		{
			//increment games won
			sessionStorage.roundWins++;	
			localStorage.totalWins++;
			
			if(sessionStorage.roundWins == 3)
			{
				endTheRound(1);
			}

			//congrats dude
			txt.appendChild(document.createTextNode("Congratulations, you won!"));
		}
		else
		{
			//sorry dude
			var correctWord = sessionStorage.currWord;
			correctWord = correctWord.toUpperCase();
			var disp = document.createElement('span');
			disp.style.color = 'red';
			disp.appendChild(document.createTextNode(correctWord));
			txt.appendChild(document.createTextNode("Sorry, you lost! The word was "));
			txt.appendChild(disp);
		}
		
		if(sessionStorage.roundPlay == 5 && sessionStorage.roundWins != 3)
		{
			endTheRound(0);
		}
		else
		{
		//increment games played this round
		sessionStorage.roundPlay++;	
		
		//increment total games played
		localStorage.totalPlay++;
		}
		
	}
	
	function otherPuzzle()
	{
		//clear page
		document.write('');
		document.close();
		
		//Welcome to Lingo, [name]!
		var title = document.createElement("h1");
		title.style.textAlign = 'center';
		document.body.appendChild(title);
		title.appendChild(document.createTextNode("Welcome to Lingo, "));
		title.appendChild(document.createTextNode(sessionStorage.name));
		title.appendChild(document.createTextNode("!"));
		
		//Round #
		var round = document.createElement("h2");
		round.id = 'roundNum';
		sessionStorage.guessNum = 1;
		round.style.textAlign = 'center';
		document.body.appendChild(round);
		round.appendChild(document.createTextNode("Round " + sessionStorage.roundNum));
		
		
		//Word Guess:           [Enter]
		var iDiv = document.createElement('div');
		iDiv.style.textAlign = 'center';
		iDiv.appendChild(document.createTextNode("Word Guess: "));
		var iGuess = document.createElement('input');
		iGuess.type = 'text';
		iGuess.id = 'guess';
		iDiv.appendChild(iGuess);
		var iButtonGuess = document.createElement('input');
		iButtonGuess.type = 'button';
		iButtonGuess.value = 'Enter';
		iButtonGuess.onclick = submitGuess;
		iDiv.appendChild(iButtonGuess);
		document.body.appendChild(iDiv);
		
		//put timer up
		resetTimer();
		document.body.appendChild(timer);		
		
		//generate blank table (5x5)
		var tbl = document.createElement("table");
		tbl.id = 'myTable';
		tbl.border = 1;
		tbl.align = 'center';
		document.body.appendChild(tbl);
		for(var i = 0; i < 5; i++)
		{
			var hrow = tbl.insertRow(i);
			hrow.align = 'center';
			for(var j = 0; j < 5; j++)
			{
				var c = hrow.insertCell(j);
				c.style.width = '20px';
				var cellContents = document.createTextNode(".");
				c.appendChild(cellContents);
			}
		}
		
		//get the word
		var row = 0;
		var word;
		switch(sessionStorage.roundPlay)
		{
			case '2':
				word = sessionStorage.word2;
				break;
			case '3':
				word = sessionStorage.word3;
				break;
			case '4':
				word = sessionStorage.word4;
				break;
			case '5':
				word = sessionStorage.word5;
				break;
			default:
				break;
		}
		sessionStorage.firstLetter = word[0];
		var guess = word[0] + "----";
		populate(row, word, guess);
	}
	
	function endTheRound(didWin)
	{
		sessionStorage.roundNum++;
		if(!localStorage.totalRound)
		{
			localStorage.totalRound = 1;
		}
		else
		{
			localStorage.totalRound++;
		}
		
		roundOne(didWin);
	}
</script>


<center>
<h1>Welcome to Lingo!</h1>
<h3>What's your name?</h3>
<input type="text" id="username">
<input type="button" value="Login" onClick="processForm(this.form)">

<body onload="checkLogin()">

</center>

</html>