/*
	reviewdesu.js
	this scripts proceeds to doing a review of the things you should know
*/

// UTILITY (copied from about.com)
// thank you the internets
Array.prototype.shuffle = function() {
	var s = [];
	while (this.length) s.push(this.splice(Math.random() * this.length, 1)[0]);
	while (s.length) this.push(s.pop());
	return this;
}

var questions = [];
var results = [];
var question = [];
var score = 0;

var total = 0;
var question_nb = 0;

function start_review() {
	prepare_questions();
	next_question();
}

function prepare_questions() {
	for (var i = 0; i < batch_data.items.length; i++) {
		for (var j = 0; j < batch_data.columns.length; j++) {
			if (batch_data.columns[j].question == true) {
				var answer = '';
				for (var k = 0; k < batch_data.items[i].length; k++) {
					if (k != j)
						answer += '<p style="text-align: center">' + batch_data.items[i][k] + "</p>";
				}
				questions.push({
					"question": batch_data.items[i][j],
					"answer": answer,
					"key": batch_data.items[i][0],
				});
			}
		}
	}
	total = questions.length;
	questions.shuffle();
}

function next_question() {
	if (questions.length == 0) {
		score = Math.ceil(score * 50 / total);
		$("core").innerHTML = '<p>Finished. Score : ' + score + '/100. Saving data...</p>';
		new Ajax.Request('index.php?p=brresults-study-' + batchid, {
			method: 'post',
			parameters: {
				score: score,
				results: Object.toJSON(results),
			},
			onSuccess: function(transport) {
				$("core").innerHTML = '<p>Finished. Score : ' + score + '/100. ' + transport.responseText + '. <a href="batch-study-' + batchid + '">back to batch</a></p>';
			},
		});
	} else {
		question = questions[questions.length - 1];
		questions.pop();
		question_nb++;

		html = '<h3>Question ' + question_nb + ' of ' + total + '</h3>';
		html += '<p style="text-align: center; font-size: 1.2em">' + question.question + '</p>';
		html += '<p><button id="flipbtn" onclick="show_answer();">answer</button></p>';
		$("core").innerHTML = html;
		$("flipbtn").focus();
	}
}

function show_answer() {
	html = '<h3>Question ' + question_nb + ' of ' + total + '</h3>';
	html += '<p style="text-align: center; font-size: 1.2em">' + question.question + '</p>';
	html += question.answer;
	html += '<p><button taborder="1" onclick="answer_question(-1);">fail</button>';
	html += '<button taborder="2" id="dunnobtn" onclick="answer_question(0);">dunno</button>';
	html += '<button taborder="3" onclick="answer_question(1);">win</button></p>';
	$("core").innerHTML = html;
	$("dunnobtn").focus();
}

function answer_question(a) {
	results.push([question.key, a]);
	score += (a+1);
	next_question();
}
