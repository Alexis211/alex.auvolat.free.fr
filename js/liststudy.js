/*	
	liststudy.js
	this script formats the data in batch_data and reviews_data to make a nice table out of it.
*/

var items = [];

var max_score = 0;
var med_score = 0;

function show_batch_table() {
	process_items();
	show_contents_table();
	show_reviews_table();
}

function process_items() {
	for (var i = 0; i < batch_data.items.length; i++) {
		items.push(
			{"info": batch_data.items[i],
			"win": 0, "fail": 0, "score": 0}
			);
	}
	for (var i = 0; i < reviews_data.length; i++) {
		for (var j = 0; j < reviews_data[i].results.length; j++) {
			var n = reviews_data[i].results[j][0];
			var s = reviews_data[i].results[j][1];
			for (var k = 0; k < items.length; k++) {
				if (items[k].info[0] == n) {
					if (s == 1) {
						items[k].win++;
						items[k].score++;
					} else if (s == -1) {
						items[k].fail++;
						items[k].score--;
					}
				}
			}
		}
	}
	for (var i = 0; i < items.length; i++) {
		if (items[i].score > max_score) max_score = items[i].score;
		med_score += items[i].score;
	}
	med_score = Math.ceil(med_score * 10 / items.length) / 10;
}

function show_contents_table() {
	var html = '<table><tr>';
	for (var i = 0; i < batch_data.columns.length; i++) {
		var c = batch_data.columns[i];
		html += '<th>' + c.name + ' - <a class="tool_link" href="#" onclick="ch(' + i + ')" id="chsl' + i + '">hide</a></th>';
	}
	html += '<th>win</th><th>fail</th><th>score</th></tr>';
	for (var i = 0; i < items.length; i++) {
		html += '<tr>';
		for (var j = 0; j < items[i].info.length; j++) {
			html += '<td><span class="cd' + j + '">' + items[i].info[j] + '</span></td>';
		}
		html += '<td>' + items[i].win + '</td>';
		html += '<td' + (items[i].fail > 0 ? (items[i].fail > items[i].win ? ' style="background-color: #ff7777"' : ' style="background-color: #FFFF00"') : '') + '>' + items[i].fail + '</td>';
		html += '<td style="background-color: ' + (items[i].score == max_score ? '#00aa00' : (items[i].score > med_score ? '#55FF55' : '#FFFF00')) + '">' + items[i].score + '</td></tr>';
	}
	html += '</table>';
	html += '<p>Medium score : ' + med_score + '</p>';
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
			else if (reviews_data[i].score >= 90)
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
