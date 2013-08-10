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
	for (var j = 0; j < batch_data.questions.length; j++) {
		var tq = [];

		var q = batch_data.questions[j];
		for (var i = 0; i < batch_data.items.length; i++) {
			if (q.col) {
				var answer = '';
				for (var k = 0; k < batch_data.items[i].length; k++) {
					answer += '<p class="review_item_prop"><strong>' + batch_data.columns[k] + '</strong>' + batch_data.items[i][k] + "</p>";
				}
				tq.push({
					"question": '<p class="review_item_q">' + batch_data.items[i][q.col] + '</p>',
					"answer": answer,
					"key": batch_data.items[i][0],
				});
			} else {
				var qu = q.q;
				var an = q.a;
				for (var k = 0; k < batch_data.items[i].length; k++) {
					qu = qu.replace('%' + k, batch_data.items[i][k]);
					an = an.replace('%' + k, batch_data.items[i][k]);
				}
				tq.push({
					"question": qu,
					"answer": an,
					"key": batch_data.items[i][0],
				});
			}
		}

		tq.shuffle();
		// first question asked is the last in array questions, so just put them in reverse order.
		questions = tq.concat(questions);
	}
	total = questions.length;
}

function next_question() {
	if (questions.length == 0) {
		score = Math.ceil(score * 100 / total);
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
		html += '<div class="review_item">';
		html += '<div class="box">' + question.question + '</div>';
		html += '<p><button id="flipbtn" onclick="show_answer();">answer</button></p>';
		html += '</div>';
		$("core").innerHTML = html;
		$("flipbtn").focus();
	}
}

function show_answer() {
	html = '<h3>Question ' + question_nb + ' of ' + total + '</h3>';
	html += '<div class="review_item">';
	html += '<div class="box2">' + question.answer + '</div>';
	html += '<div class="boxn" onclick="edit_note();" id="notebox">' + (notes[question.key] || '<em>click to add note...</em>') + '</div>';
	html += '<p><button taborder="1" onclick="answer_question(-1);">fail</button>';
	html += '<button taborder="2" id="dunnobtn" onclick="answer_question(0);">dunno</button>';
	html += '<button taborder="3" id="winbtn" onclick="answer_question(1);">win</button></p>';
	html += '</div>';
	$("core").innerHTML = html;
	$("winbtn").focus();
}

function answer_question(a) {
	results.push([question.key, a]);
	score += a;
	next_question();
}

function edit_note() {
	var idd = question.key;
	var note = prompt("Add note for item:", notes[idd] || '');
	if (note != null) notes[idd] = note;
	if (notes[idd] == '') delete notes[idd];
	$("notebox").innerHTML = (notes[idd] || '<em>click to add note...</em>');

	new Ajax.Request('index.php?p=brresults-study-' + batchid, {
		method: 'post',
		parameters: {
			notes: Object.toJSON(notes),
		},
		onSuccess: function(transport) {
			// nothing...
		},
	});
}

