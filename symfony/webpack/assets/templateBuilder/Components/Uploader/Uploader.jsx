import React, { useEffect, useState} from 'react';
import GraphItem from '../GraphItem/GraphItem';
import * as XLSX from 'xlsx';
import PDFDocument from '../PDFDocument/PDFDocument.jsx';
import PDFContent from '../PDFContent/PDFContent';

let ITEM = {
    productCode: 0,
    zoneCode: 2,
    score: 3,
    sessionId: 4,
    value: 5
};

export default function Uploader(){
    const [ dataGraph, setDataGraph ] = useState({});
    const [ legends, setLegends ]     = useState({});
  
    const getLegends = (data) => {
      //data = data.filter( d => d[0] !== undefined && d[0] !== '' && ['number', 'string'].includes(typeof d[0]));
      //let checkValue = (toCheck) => toCheck[0] !== undefined && toCheck[0] !== '' && ['number', 'string'].includes(typeof toCheck[0]);
      let productCode = {};
      let zoneCode    = {};
      let sessionId   = {};
      let score       = {};
  
      for(let row of data){
        if( row[0] )  score[row[0]]       = row[1];
        if( row[3] )  productCode[row[2]] = row[3];
        if( row[8] )  zoneCode[row[7]]    = row[8];
        if( row[6] )  sessionId[row[5]]   = row[6];
      };
      setLegends({score, productCode, zoneCode, sessionId});
    };
    
    const sortrows = data => {
      let graphPoints   = {};
      let sessions      = sortBySession(data);
      let products      = sortByProduct(data);
  
      for(let product of products){
        let items = data.filter( row => row[ITEM.productCode] === product);
        graphPoints[product] = {};
        
        for(let session of sessions){
          let itemsOfSession = items.filter( row => row[ITEM.sessionId] === session).map(r => r[ITEM.value]);
          let avg = itemsOfSession.reduce( (a,acc) => parseFloat(a)+acc, 0) / itemsOfSession.length;
          if(legends?.sessionId){
            let idx = legends.sessionId[session];
            graphPoints[product][idx] = avg.toFixed(2);
          }
  
        };
      }
  
      if( Object.entries(Object.values(graphPoints)[0]).length < 1) return
      //if( !graphPoints[legends.productCode[0]] || Object.entries(graphPoints[legends.productCode[0]]).length < 1 ) return;
      setDataGraph(graphPoints);
    };
  
    const sortBySession = rows => {
      let tmpRows = rows.map( row => row[ITEM.sessionId]);
      return tmpRows.filter( (row, index) => tmpRows.indexOf(row) === index);
    };
  
    const sortByProduct = rows => {
      let tmpRows = rows.map( row => row[ITEM.productCode]);
      return tmpRows.filter( (row, index) => tmpRows.indexOf(row) === index);
    };
  
    const handleFile = (file /*:File*/) => {
      /* Boilerplate to set up FileReader */
      const reader = new FileReader();
      const rABS = !!reader.readAsBinaryString;
  
      reader.onload = e => {
        const bstr = e.target.result;
        const wb = XLSX.read(bstr, {type:'binary'});
  
        /* Get Legends labels */
        let wsname = wb.SheetNames[0];
        let ws = wb.Sheets[wsname];
        //const data = XLSX.utils.sheet_to_csv(ws, {header:1}); // returns string
        let legendsData = XLSX.utils.sheet_to_json(ws, { header: 1});
        legendsData.shift(); //removing the header
        getLegends(legendsData);
  
        /* Get 2nd worksheet / raw data */
        wsname = wb.SheetNames[1];
        ws = wb.Sheets[wsname];
        //const data = XLSX.utils.sheet_to_csv(ws, {header:1}); // returns string
        const data = XLSX.utils.sheet_to_json(ws, { header: 1});
        data.shift(); //removing the header
        sortrows(data);
      };
      if (rABS) reader.readAsBinaryString(file);
      else reader.readAsArrayBuffer(file);
    };
  
    const handleChange = e => {
      const files = e.target.files;
      if (files && files[0]) handleFile(files[0]);
      e.target.value=null;
    };
  
    return (
      <div className="Uploader">
        {Object.keys(dataGraph).length < 1
        ?
            <input
            type="file"
            id="file"
            accept={'.xlsx'}
            onChange={handleChange}
            />
        :
        <PDFDocument>
          <PDFContent
            productsList={legends.productCode}
            data={dataGraph} />
        </PDFDocument>
        }

      </div>
    );

};