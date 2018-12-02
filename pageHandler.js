spriteList=["sprites/barrel","sprites/enchantingTable","sprites/evergreenTree","sprites/dirtGround","sprites/grassGround","sprites/stoneGround"];
rowCount=7;
colCount=9;
tileSize=0;
viewStart=[0,0];

window.onresize = function(event) {
	canvasResize();
	draw();
};
function canvasSetup() {
	canvasResize();
	layrCnv=[];
	layrCtx=[];
	rowsCnv=[];
	rowsCtx=[];
	for(var z=0; z<3; z++) {
		layrCnv.push(document.createElement('canvas'));
		layrCnv[z].width=(colCount+1)*tileSize;
		layrCnv[z].height=(rowCount+1)*tileSize;
		layrCtx.push(layrCnv[z].getContext('2d'));
		layrCtx[z].imageSmoothingEnabled=false;
		rowsCnv.push([]);
		rowsCtx.push([]);
		for(var y=0; y<rowCount; y++) {
			rowsCnv[z].push(document.createElement('canvas'));
			rowsCnv[z][y].width=(colCount+1)*tileSize;
			rowsCnv[z][y].height=2*tileSize;
			rowsCtx[z].push(rowsCnv[z][y].getContext('2d'));
			rowsCtx[z][y].imageSmoothingEnabled=false;
		}
	}
}
function canvasResize() {
	canvas=document.getElementById("viewWindow");
	width=canvas.width=$(window).width();
	height=canvas.height=$(window).height();
	ctx=canvas.getContext('2d');
	ctx.imageSmoothingEnabled=false;
	if(height/width>rowCount/colCount) {
		tileSize=width/colCount;
		viewStart=[0,(height-rowCount*tileSize)/2];
	}
	else {
		tileSize=height/rowCount;
		viewStart=[(width-colCount*tileSize)/2,0];
	}
}
function loadSprites() {
	sprite={};
	for(var i=0; i<spriteList.length; i++) {
		sprite[spriteList[i]]=document.createElement('img');
		sprite[spriteList[i]].src="img/"+spriteList[i]+".png";
	}
}
function generalSetup() {
	loadSprites();
	viewMap=[];
	for(var z=0; z<3; z++) {
		viewMap.push([]);
		for(var y=0; y<rowCount; y++) {
			viewMap[z].push([]);
			for(var x=0; x<colCount; x++) {
				viewMap[z][y].push({id:"blank",sprite:"none"});
			}
		}
	}
}
function updateLayer(layerNum,rows2Update) {
	var z=layerNum;
	for(var i=0; i<rows2Update.length; i++) {
		var y=rows2Update[i];
		rowsCtx[z][y].clearRect(0,0,rowsCnv[z][y].width,rowsCnv[z][y].height);
		for(var x=0; x<colCount; x++) {
			if(viewMap[z][y][x].sprite!="none") {
				rowsCtx[z][y].drawImage(sprite[viewMap[z][y][x].sprite],tileSize*x,0,tileSize*2,tileSize*2);
			}
		}
	}
	console.log(z);
	layrCtx[z].clearRect(0,0,layrCnv[z].width,layrCnv[z].height);
	for(var y=0; y<rowCount; y++) {
		layrCtx[z].drawImage(rowsCnv[z][y],0,tileSize*y,tileSize*(colCount+1),tileSize*2);
	}
}
function draw() {
	ctx.clearRect(0,0,width,height);
	ctx.fillStyle="#000000";
	ctx.fillRect(0,0,width,height);
	for(var i=0; i<3; i++) {
		ctx.drawImage(layrCnv[i], viewStart[0]-tileSize/2, viewStart[1]-tileSize/2, (colCount+1)*tileSize, (rowCount+1)*tileSize);
	}
	if(height/width>rowCount/colCount) {
		ctx.fillRect(0,0,width,viewStart[1]);
		ctx.fillRect(0,viewStart[1]+(rowCount*tileSize),width,viewStart[1]);
	}
	else {
		ctx.fillRect(0,0,viewStart[0],height);
		ctx.fillRect(viewStart[0]+(colCount*tileSize),0,viewStart[0],height);
	}
}
function displayTest() {
	var newsprite=false;
	for(var z=0; z<3; z++) {
		for(var y=0; y<rowCount; y++) {
			for(var x=0; x<colCount; x++) {
				viewMap[z][y][x].sprite="testSprites/testSprite."+z+"."+y+"."+x;
				if(spriteList.indexOf("testSprites/testSprite."+z+"."+y+"."+x)==-1) {
					spriteList.push("testSprites/testSprite."+z+"."+y+"."+x);
					newsprite=true;
				}
			}
		}
	}
	if(newsprite) {
		loadSprites();
	}
	console.log("Please wait...");
	setTimeout(function() {
		var tileList=[];
		for(var i=0; i<rowCount; i++) {
			tileList.push(i);
		}
		console.log(tileList);
		for(var i=0; i<3; i++) {
			updateLayer(i,tileList);
		}
		draw();
		console.log("Loaded.");
	},1000)
}
function tileAll(layrNum,spriteName) {
	var newsprite=false;
	for(var y=0; y<rowCount; y++) {
		for(var x=0; x<colCount; x++) {
			viewMap[layrNum][y][x].sprite=spriteName;
		}
	}
	var tileList=[];
	for(var i=0; i<rowCount; i++) {
		tileList.push(i);
	}
	updateLayer(layrNum,tileList);
	draw();
}