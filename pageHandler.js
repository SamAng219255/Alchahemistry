spriteList=[];
rowCount=7;
colCount=9;
tileSize=0;
viewStart=[0,0];

window.onresize = function(event) {
	canvasResize();
};
function canvasSetup() {
	layrCnv=[];
	layrCtx=[];
	rowsCnv=[];
	rowsCtx=[];
	for(var z=0; z<3; z++) {
		layrCnv.push(document.createElement('canvas'));
		layrCtx.push(cnvsRows[z]);
		rowsCnv.push([]);
		rowsCtx.push([]);
		for(var y=0; y<rowCount; y++) {
			rowsCnv[z].push(document.createElement('canvas'));
			rowsCtx[z].push(cnvsRows[z][y]);
		}
	}
	canvasResize();
}
function canvasResize() {
	canvas=document.getElementById("viewWindow");
	width=canvas.width=$(window).width();
	height=canvas.height=$(window).height();
	ctx=canvas.getContext('2d');
	if(height/width>rowCount/colCount) {
		tileSize=width/colCount;
		viewStart=[(height-rowCount*tileSize)/2,0];
	}
	else {
		tileSize=height/rowCount;
		viewStart=[0,(width-colCount*tileSize)/2];
	}
}
function generalSetup() {
	sprite={};
	for(var i=0; i<spriteList.length; i++) {
		sprite[spriteList[i]]=document.createElement('img');
		sprite[spriteList[i]].src=spriteList[i]+".png";
	}
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
		rowsCtx.clearRect(0,0,tileSize*colCount,tileSize);
		for(var x=0; x<colCount; x++) {
			if(map[z][y][z].sprite!="none") {
				rowsCtx.drawImage(sprite[map[z][y][z].sprite],tileSize*x,0,tileSize,tileSize);
			}
		}
	}
	layrCtx.clearRect(0,0,tileSize*colCount,tileSize*rowCount);
	for(var y=0; y<rowCount; y++) {
		layrCtx.drawImage(rowsCnv[y],0,tileSize*y,tileSize*colCount,tileSize)
	}
}
function draw() {
	for(var i=0; i<3; i++) {
		ctx.drawImage(layrCnv[i], viewStart[0], viewStart[1], rowCount*tileSize, tileSize);
	}
}