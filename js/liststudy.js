/*	
	liststudy.js
	this script formats the data in batch_data and reviews_data to make a nice table out of it.
*/

var items = [];

var max_score = 0;
var med_score = 0;
var avg_score = 0;

function show_batch_table() {
	process_items();
	show_contents_table();
	show_reviews_table();
}

function process_items() {
	var item_idx = {};

	for (var i = 0; i < batch_data.items.length; i++) {
		var d = batch_data.items[i];
		item_idx[d[0]] = items.length;
		items.push(
			{"info": d,
			"win": 0, "fail": 0, "score": 0, "marker": ""}
			);
	}

	// Calculate total wins and losses
	for (var i = 0; i < reviews_data.length; i++) {
		for (var j = 0; j < reviews_data[i].results.length; j++) {
			var n = reviews_data[i].results[j][0];
			var s = reviews_data[i].results[j][1];
			var k = item_idx[n];
			if (s == 1) {
				items[k].win++;
				items[k].score++;
			} else if (s == -1) {
				items[k].fail++;
				items[k].score--;
			}
		}
	}

	// Make marker indication : -1 (fail) -> red, 0 (dunno) -> yellow
	if (reviews_data.length > 0) {
		var t = reviews_data[reviews_data.length - 1].results;
		for (var j = 0; j < t.length; j++) {
			var s = t[j][1];
			if (s == 1) continue;
			var n = t[j][0];
			var k = item_idx[n];
			items[k].marker = items[k].marker + '<span style="color: ' + (s == 0 ? '#FFAA00' : '#FF0000') + '">*</span>';
		}
	}


	// Get max score
	for (var i = 0; i < items.length; i++) {
		if (items[i].score > max_score) max_score = items[i].score;
		avg_score += items[i].score;
	}
	avg_score = Math.ceil(avg_score * 20 / items.length) / 20;
	med_score = max_score / 2;
}

function show_contents_table() {
	var html = '<table><tr><th style="border: none; background: transparent"></th>';
	for (var i = 0; i < batch_data.columns.length; i++) {
		var c = batch_data.columns[i];
		html += '<th>' + c + ' - <a class="tool_link" href="#" onclick="ch(' + i + ')" id="chsl' + i + '">hide</a></th>';
	}
	html += '<th>win</th><th>fail</th><th>score</th></tr>';
	for (var i = 0; i < items.length; i++) {
		html += '<tr>';
		html += '<td style="border: none; background: transparent; padding: 0px; padding-top: 8px; font-weight: bold;">' + items[i].marker + '</td>';
		for (var j = 0; j < items[i].info.length; j++) {
			html += '<td><span class="cd' + j + '">' + items[i].info[j] + '</span></td>';
		}
		html += '<td>' + items[i].win + '</td>';
		html += '<td' + (items[i].fail > 0 ? (items[i].fail > items[i].win ? ' style="background-color: #ff7777"' : ' style="background-color: #FFFF00"') : '') + '>' + items[i].fail + '</td>';
		html += '<td style="background-color: ' + 
			(items[i].score == max_score ? '#00aa00' : 
			(items[i].score >= med_score ? '#55FF55' : 
			(items[i].score < 0 ? '#FF7777' : '#FFFF00'))) + '">' + items[i].score + '</td></tr>';
	}
	html += '</table>';
	html += '<p>Average score : ' + avg_score + '</p>';
	$("items").innerHTML = html;
}

function ch(col) {
	$$(".cd"+col).invoke("hide");
	$("chsl"+col).innerHTML = 'show';
	$("chsl"+col).onclick = function() { cs(col); };
}

function cs(col) {
	$$(".cd"+col).invoke("show");
	$("chsl"+col).innerHTML = 'hide';
	$("chsl"+col).onclick = function() { ch(col); };
}

function show_reviews_table() {
	// eventually, will also show a graph of progress. or maybee not.
	if (reviews_data.length == 0) {
		$("reviews").innerHTML = "No reviews... yet.";
	} else {
		var html = '<table><tr><th>review date</th><th>score</th></tr>';
		for (var i = 0; i < reviews_data.length; i++) {
			var color = '';
			if (reviews_data[i].score == 100)
				color = '#00aa00';
			else if (reviews_data[i].score >= 80)
				color = '#55FF55';
			else if (reviews_data[i].score >= 50)
				color = '#FFFF00';
			else
				color = '#FF7777';
			html += '<tr><td>' + reviews_data[i].date + '</td><td style="background-color: ' + color + '">' + reviews_data[i].score + '/100</td></tr>';
		}
		html += '</table>';

		$("reviews").innerHTML = html;
	}
}
