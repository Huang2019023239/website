async function loadmodel(datalast) {

    const model = await tf.loadLayersModel('https://cdn.jsdelivr.net/npm/peloop@1.0.1/model.json');

    const input = tf.tensor2d([datalast], [1, 101]);
    const predictOut = model.predict(input);
    var result = predictOut.dataSync()[0]
    if (result>0.5){
        predict = "ferroelectric"
    }
    else {
        predict = "non-ferroelectric"
    }
    str = "The probability of the loop</br>" +
        "1) for being ferroelectric is: "+(result*100).toFixed(2)+"%</br>2) for being non-ferroelectric is: "
        +((1-result)*100).toFixed(2)+"%</br><br>So the loop may be :";
    var p0 = document.getElementsByTagName("p")[0];
    var p1 = document.getElementsByTagName("p")[1];
    p0.innerHTML = str;
    p1.innerHTML = predict;

}
function read_and_stddata(csvString){
    let csvarry = csvString.split("\r\n");
    let data = [];
    let dataabs=[];
    let datastd=[];
    let finaldata=[];
    let max;
    for(let i = 0;i<csvarry.length-1;i++){

        let temp = csvarry[i].split("\t");
        data.push(temp[1]);
    }
    //console.log(data);
    for(let j= 0; j<data.length;j++){
        dataabs.push(Math.abs(data[j]));
    }
    max=Math.max.apply(null,dataabs);
    for(let k = 0;k<data.length;k++){
        datastd.push(data[k]/max);
    }
    if (Number.isInteger((datastd.length-1)/100)){
        let multiple = ((datastd.length-1)/100);
        for(var l = 0; l<datastd.length;l=l+multiple)
            finaldata.push(datastd[l]);
    }
    else {
        return false;
    }
    return finaldata;
}
function stateChanged()
{
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    {
        document.getElementById("txtHint").innerHTML=xmlHttp.responseText
    }
}

function GetXmlHttpObject()
{
    var xmlHttp=null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
    }
    catch (e)
    {
        // Internet Explorer
        try
        {
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}
async function drawloop(csvString) {
    let csvarry = csvString.split("\r\n");
    let c = document.getElementById("myCanvas");
    let context = c.getContext("2d");
    let padding = 50;
    let Step=30;
    let long = c.width-2*padding;
    let fillratio = 0.85/2;
    let dataV = [];
    let dataP = [];
    let maxV;
    let maxP;
    for(let i = 0;i<csvarry.length-1;i++){

        let temp = csvarry[i].split("\t");
        dataV.push(temp[0]);
        dataP.push(temp[1]);
    }
    (Math.max.apply(null,dataV))>(Math.abs(Math.min.apply(null,dataV)))?maxV=(Math.max.apply(null,dataV)):maxV=(Math.abs(Math.min.apply(null,dataV)));
    (Math.max.apply(null,dataP))>(Math.abs(Math.min.apply(null,dataP)))?maxP=(Math.max.apply(null,dataP)):maxP=(Math.abs(Math.min.apply(null,dataP)));
    let center = (Math.max.apply(null,dataP)-Math.min.apply(null,dataP))/2;
    let mindataP=Math.abs(Math.min.apply(null,dataP));
    context.clearRect(0,0,c.width,c.height);
    context.strokeStyle = "#070000";
    context.strokeRect(padding,padding,long,long);
    //drawGrid(context,'lightgray', Step);
    //drawAxisTicks(context,padding,long,Step,'black');
    context.beginPath();
    context.moveTo(dataV[0]/maxV*fillratio*long+200,-((dataP[0]-(center-mindataP))/maxP*fillratio*long)+200);
    for (var i = 1; i < dataV.length; i++) {
        context.lineTo(dataV[i]/maxV*fillratio*long+200,-((dataP[i]-(center-mindataP))/maxP*fillratio*long)+200);
    }
    //drawAxislabels(maxV,maxP,fillratio,context,padding,long,Step,'black');
    drawlabels(context,padding,long);
    context.stroke();

}
function drawGrid(context,color, step) {
    context.save();
    context.strokeStyle = color;
    context.lineWidth = 2.5;
    for (let i = step + 50; i < 350; i += step) {
        context.beginPath();
        context.moveTo(i, 50);
        context.lineTo(i, 350);
        context.stroke();
    }

    for (let i = step + 50; i < 350; i += step) {
        context.beginPath();
        context.moveTo(50, i);
        context.lineTo(350, i);
        context.stroke();
    }
    context.restore();
}
function drawAxisTicks(context,padding,long,step,color) {
    drawVerticalAxisTicks(context,padding,long,step,color);
    drawHorizontalAxisTicks(context,padding,long,step,color);

}
function drawAxislabels(maxV,maxP,fillratio,context,padding,long,Step,color) {
    drawVerticalAxisLabels(maxP,fillratio,context,padding,long,Step,color)
    drawHorizontalAxisLabels(maxV,fillratio,context,padding,long,Step,color)
}
function drawVerticalAxisTicks(context,padding,long,step,color) {
    let delta = 5;
    let NUM_TICKS = 5;
    context.save();
    context.strokeStyle = color;
    for (let i = 0; i < NUM_TICKS; i++) {
        context.beginPath();
        //第2个刻度为长的小刻度
        i  === 2 ? context.lineWidth = 5 : context.lineWidth = 2.5;
        context.moveTo(padding - delta, padding + step +2*i*step);
        context.lineTo(padding + delta, padding + step +2*i*step);
        context.stroke();

    }
    context.restore();
}
function drawHorizontalAxisTicks(context,padding,long,step,color) {
    let delta = 5;
    let NUM_TICKS = 5;
    context.save();
    context.strokeStyle = color;
    for (let i = 0; i < NUM_TICKS; i++) {
        context.beginPath();
        //第2个刻度为长的小刻度
        i  === 2 ? context.lineWidth = 5 : context.lineWidth = 2.5;
        context.moveTo(padding + step +2*i*step, padding + long-delta);
        context.lineTo(padding + step +2*i*step, padding + long+delta);
        context.stroke();

    }
    context.restore();
}
function drawVerticalAxisLabels(maxP,fillratio,context,padding,long,step,color) {
    context.save();
    context.textAlign = 'right';
    context.textBaseline = 'middle'
    let NUM_TICKS = 5;
    let scale = (maxP/fillratio/10);
    context.font="20px Arial";
    for (let i=0; i <NUM_TICKS; ++i) {
        context.fillText(((2*i-4)*scale).toFixed(1),
            padding-10,
            padding + step +2*i*step);
    }
    context.restore();
}
function drawHorizontalAxisLabels(maxV,fillratio,context,padding,long,step,color) {
    context.save();
    context.textAlign = 'center';
    context.textBaseline = 'top';
    let NUM_TICKS = 5;
    let scale = (maxV/fillratio/10)
    context.font="20px Arial";
    for (let i=0; i <NUM_TICKS; ++i) {
        context.fillText(((2*i-4)*scale).toFixed(2),
            padding + step +2*i*step,
            padding + long+10);
    }
    context.restore();

}
function drawlabels(context,padding,long) {
    context.save();
    context.textAlign = 'right';
    context.textBaseline = 'middle';
    context.font="italic 20px Time New Roman";
    context.fillText("P",
        padding -10,
        padding + long/2);
    context.textAlign = 'center';
    context.textBaseline = 'top';
    context.fillText("E",
        padding +long/2,
        padding +long+ 10);

}

