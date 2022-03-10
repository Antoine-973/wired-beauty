import React, { useEffect, useState } from 'react';
import * as XLSX from 'xlsx';

export default function Step0({goNext}){
    const [ details, setDetails ] = useState({});
    const [ excelData, setExcelData ] = useState(null);

    const goToNext = () => {
        try{
            let { title, subTitle } = details;
            if( !title || !subTitle) throw new Error('Missing details');
            let { legends, rawData } = excelData;
            goNext({legends, rawData, studyDetails: details});
        }catch(e){
            console.error(e);
        }
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
            let legends = XLSX.utils.sheet_to_json(ws, { header: 1});

            /* Get 2nd worksheet / raw data */
            wsname = wb.SheetNames[1];
            ws = wb.Sheets[wsname];
            const rawData = XLSX.utils.sheet_to_json(ws, { header: 1});

            let tmpData = { legends, rawData };
            //goNext(tmpData);
            setExcelData(tmpData);
        };
        if (rABS) reader.readAsBinaryString(file);
        else reader.readAsArrayBuffer(file);
    };

    const handleChange = e => {
        const files = e.target.files;
        if (files && files[0]) handleFile(files[0]);
        e.target.value=null;
    };
    
    return(
        <div>
            { !excelData
            ?
                <input
                    type="file"
                    id="file"
                    accept={'.xlsx'}
                    onChange={handleChange}
                    />
            :
                <div>
                    <input
                        placeholder='Title used for the front page'
                        type="text" 
                        value={details?.title}
                        onChange={ e => setDetails({ ...details, title: e.target.value})}
                        />
                    <input 
                        type="text" 
                        placeholder='Sub title figuring in the second page'
                        value={details?.subTitle}
                        onChange={ e => setDetails({ ...details, subTitle: e.target.value})}
                    />
                    <button onClick={goToNext}>OK</button>
                </div>
            }
        </div>
    )
}