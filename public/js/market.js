var url = $('base').attr('href');
var allTickerData;
var marketTablesJsLoaded = false;


function getTickerInfo(){
console.log('getTickerInfo');
	$.getJSON(ajaxUrl+'/marketTreicker', function(d) {
		allTickerData = d;
		writeMarketTable('USDT');
		writeMarketTable('BTC');
		
		//writeMarketTable('DOCH');
		activateMarketTableClicks();
		initMarketTables();
		load_market_details();
	});
}

function clickMarketTableRow(r) {
		var pair = r.parent().attr('data-url').toUpperCase();

		orderbookDisplayLimit = defaultOrderbookDisplayLimit;
		currencyPair = pair;

		var pairArr = currencyPair.split('_');
		primaryCurrency = pairArr[0];
		secondaryCurrency = pairArr[1];

		window.location.hash = '#' + primaryCurrency.toLowerCase() + '_' + secondaryCurrency.toLowerCase();
}

function activateMarketTableClicks() {
	// click table row to update big chart

	$('.markets tbody td').click(function(e){
		e.preventDefault();
		$(".markets tbody tr").removeClass("active");
		$(this).closest("tr").addClass("active");

		// Detect if the user wants to open a new tab/window.
		if(e.shiftKey || e.ctrlKey){
			window.open((margin ? "/marginTrading#" : "/exchange#") + $(this).parent().attr('data-url'));
		} else {
			clickMarketTableRow($(this));
		}
	});

	/*$('.markets tbody td.star').click(function(){
		toggleStar($(this));
	});*/

	// Show star only
	/*$('#marketStar').change(function(){
		filterNonStarred();
		setFilterMessage();
		resetMatketTableHeights();
		saveExchangeSettings();
		showStarOnly = $(this).is(":checked");
	});*/
}

function getCurrentPairDetails() {
	var row = allTickerData[currencyPair];
	var ch =  exactRound(row.percentChange * 100,2);
	var chPosNeg = 'positive';
	if (ch < 0) { chPosNeg = 'neg';}
	if (ch >= 0) {
		ch = String('+') + ch;
	}

	var d = {
		name: getName(secondaryCurrency),
		pair: secondaryCurrency + '/' + primaryCurrency,
		last: row.last,
		change:  ch + '%',
		chPosNeg: chPosNeg,
		high: row.highestBid,
		low: row.lowestAsk,
		p0: primaryCurrency,
		p1: secondaryCurrency, 
		baseVol: row.baseVolume, 
		quoteVol: row.quoteVolume,
		high24hr: row.high24hr,
		low24hr: row.low24hr,
		currentPrice:row.currentBuyPrice
	};
	return d;
}


var marketTablesLoaded = 0;
function initMarketTables(){

	var options = {
		'paging': false,
		'autoWidth': true,
		'info': false,
        "searching": false,
		'scrollY': 221,
		'bSort': false,
		'language': { "emptyTable": "No market is available" },
		'fnInitComplete': function() {
			marketTablesLoaded++;
		}
    	
	};

	//$('#marketUSD').dataTable(options);

	//marketBTCTable = $('#marketBTC').dataTable().draw();
}


function writeMarketTable(coin) {

	var arr = currencyPairArray.filter(function(d, i) {
		return (d.substr(0, coin.length) === coin) && (available.indexOf(d.substr(0, coin.length)) >= 0) ;
	});

	var rows = '';
	for (var i = 0; i < arr.length; i++) {
		rows += getRow(arr[i],coin);
	}

	$('#market' + coin + ' tbody').html(rows);
}


function formatTickerData(pair, tickerData) {
    var pairArray = pair.split("_"),
    	base = pairArray[0],
    	quote = pairArray[1],
        name = getName(quote),
        decimals;

    tickerData.url =  pair.toLowerCase();
    tickerData.pair = pair;
    tickerData.primary = base;
    tickerData.secondary = quote;
    tickerData.symbol = quote;
    tickerData.balance = 0.0;
    tickerData.value = 0.0;

    tickerData.price = tickerData.last;

    //~ tickerData.volume = exactRound(tickerData.baseVolume,3);
    tickerData.volume = exactRound(tickerData.baseVolume,8);
    tickerData.change = exactRound(tickerData.percentChange * 100,2);
    tickerData.changeDirection = "positive";
    tickerData.displayChange = tickerData.change;
    tickerData.name = "";
    tickerData.class = "";



    if(name){
        tickerData.name = name;
    }
    tickerData.frozen = '';
    if (tickerData.isFrozen === '1') { 
    	tickerData.frozen = 'frozen';
    }
    
    if(tickerData.change < 0) {
        tickerData.changeDirection = "neg";
    }
    else {
        tickerData.displayChange = '+' + tickerData.displayChange;
    }

    return tickerData;
}


function getRow(pair,coin) {

	var d = formatTickerData(pair, allTickerData[pair]);
	var active = '';
	var starOff = '';
	var starContents = '~';
	var pair = (primaryCurrency + '_' + secondaryCurrency).toLowerCase();
	var precision = (coin=="USDT") ? 2 : 8;

	if (d.url == pair && active =='') { active = ' active'; }

	// if this is marked as non-starred in settings
	
		starOff = ' starOff';
		starContents = '';
	

	var row = '<tr  data-url="' + d.url + '" id="marketRow' + d.url + '" class="marketRow ' + d.frozen + active + starOff + '">';
	row += '<td class="coin">' + d.secondary + '/' +d.primary+'</td>';
	if (!d.frozen){
		//~ row += '<td class="price">' + exactRound(d.price, 2) + '</td>';
		row += '<td class="price">' + exactRound(d.price, precision) + '</td>';
		row += '<td class="volume">' + exactRound(d.volume, precision) + '</td>';
		row += '<td class="change ' + d.changeDirection + '">' + d.displayChange + '</td>';
		//row += '<td class="bid">' + exactRound(d.highestBid, 2) + '</td>';
		//row += '<td class="ask">' + exactRound(d.lowestAsk, 2) + '</td>';
	} else {
		row += '<td class="price">&nbsp;FROZEN</td>'; // nbsp is used to make FROZEN appear last in sorting order
		row += '<td class="volume"></td>';
		row += '<td class="change"></td>';
		//row += '<td class="bid"></td>';
		//row += '<td class="ask"></td>';
	};

	/*row += '<td class="colName"><div class="ellipsis" title="' + d.name + '">' + d.name + '</div></td>';*/
	row += '</tr>';

	return row;
}

function getName(coin) {
	return currencyNamesArray[coin];
}
