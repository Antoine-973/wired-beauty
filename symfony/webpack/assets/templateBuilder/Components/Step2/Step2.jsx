import React, { useState, useEffect } from 'react';
import * as XLSX from 'xlsx';
import GraphRenderer from '../GraphRenderer/GraphRenderer';
import PDFRenderer from '../PDFRenderer/PDFRenderer';

export default function Step2({configs, excelData, studyDetails}){
    const [ data, setData ] = useState([]);
    const [ excelRows, setExcelRows ] = useState([]);

    const handleAdvancedData = cols => {
        // indexA = X, indexB = Y, indexC = filter that differs each line
        let indexA       = cols[0]; 
        let valuesOfColA = excelRows.map( row => row[indexA]);
        valuesOfColA     = valuesOfColA.filter( (row, index) => valuesOfColA.indexOf(row) === index );
        valuesOfColA     = valuesOfColA.sort( (a, b) => a - b);

        let indexB       = cols[1];
        let valuesOfColB = excelRows.map( row => row[indexB]);
        valuesOfColB     = valuesOfColB.filter( (row, index) => valuesOfColB.indexOf(row) === index );

        let indexC       = cols[2];
        let valuesOfColC = excelRows.map( row => row[indexC]);
        valuesOfColC     = valuesOfColC.filter( (row, index) => valuesOfColC.indexOf(row) === index );

        let lines = {};
        for( let filter of valuesOfColC ){
            let items = excelRows.filter( row => row[indexC] === filter);
            lines[filter] = [];

            for( let cat of valuesOfColA){
                let itemsOfCat = items.filter( row => row[indexA] === cat);
                itemsOfCat = itemsOfCat.map( r => r[indexB]);
                let avg = itemsOfCat.reduce( (a,acc) => parseFloat(a)+acc, 0) / itemsOfCat.length;
                //bars= [...bars, {name: cat, values: avg.toFixed(2)}];
                lines[filter].push( { filter, name: cat, values: avg.toFixed(2)} )
                //lines[filter] = { name: cat, values: avg.toFixed(2)}
            }

        }
        return lines;
    };

    /*
    [{
        name: "Page A",
        uv: 4000,
        pv: 2400,
        amt: 2400
    }, ...]
    */
    const handleSimpleData = cols => {
        // indexA = X, indexB = Y
        let indexA       = cols[0]; 
        let valuesOfColA = excelRows.map( row => row[indexA]);
        valuesOfColA     = valuesOfColA.filter( (row, index) => valuesOfColA.indexOf(row) === index );

        let indexB       = cols[1];
        let valuesOfColB = excelRows.map( row => row[indexB]);
        valuesOfColB     = valuesOfColB.filter( (row, index) => valuesOfColB.indexOf(row) === index );

        let bars = [];
        for( let cat of valuesOfColA){
            let items = excelRows.filter( row => row[indexA] === cat);
            items = items.map( r => r[indexB]);
            let avg = items.reduce( (a,acc) => parseFloat(a)+acc, 0) / items.length;
            bars= [...bars, {name: cat, values: avg.toFixed(2)}];
        }
        return bars;
    };

    const handleData = () => {
        let tmpData = [];
        for(let config of configs){//config = { columns, advancedMode}
            let points;
            if(config.advancedMode){
                points = {type: 'line', data: handleAdvancedData(config.columns), details: config.details};
            }else{
                points = {type: 'bar', data: handleSimpleData(config.columns), details: config.details};
            }
            tmpData = [...tmpData, points];
        }
        //console.log(tmpData)
        setData(tmpData);
    };

    useEffect(() => {
        let tmpXlRows = excelData.rawData;// excelData = {legends, rawData}
        tmpXlRows.shift();// Removing the header
        setExcelRows(tmpXlRows);
    }, [excelData]);

    useEffect(() => {
        if(excelRows.length > 0){
            handleData();
        }
    }, [excelRows]);

    useEffect(()=>{
        console.log(studyDetails);
    }, []);

    return(
        <div style={{display: 'flex', flexDirection: 'column', width: '30%'}}>
            <h3>Step 3</h3>
            {data.length > 0 && 
            <PDFRenderer studyDetails={studyDetails}>
                <GraphRenderer graphData={data} />
            </PDFRenderer>
            }
        </div>
    )
}