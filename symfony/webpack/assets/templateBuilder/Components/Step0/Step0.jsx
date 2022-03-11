import React, { useRef, useState } from 'react';
import * as XLSX from 'xlsx';
import './Step0.scss';

export default function Step0({goNext}){
    const [ details, setDetails ] = useState({});
    const [ excelData, setExcelData ] = useState(null);
    const [ filename, setFilename ]   = useState(null);
    const inputFileRef = useRef();

    const goToNext = () => {
        try{
            if( !excelData ) throw new Error('Empty excel data');
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
        if (files && files[0]){
            if(files[0].type !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
                alert('Warning! It\'s probably not the right format.')
            }
            handleFile(files[0]);
            setFilename(files[0].name);
        }
        e.target.value=null;
    };
    
    return(
        <div className='report-step-0'>
            <div className='report-import-file'>
                <label>Import</label>
                <div className='report-importer-zone'>
                    { !filename 
                        ? <p>Choose a file*</p>
                        : <p>{filename}</p>
                    }
                    { !filename 
                    ?
                        <div>
                            <svg cursor='pointer'
                                onClick={() => inputFileRef.current.click()}
                                width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.5" y="0.5" width="34" height="34" stroke="#082C36"/>
                                <g clip-path="url(#clip0_132_349)">
                                <path d="M17.5449 8V21.1958" stroke="#082C36" stroke-miterlimit="10"/>
                                <path d="M12.8945 16.9004C13.9383 17.3324 14.886 17.9684 15.6825 18.7713C16.4646 19.5396 17.0744 20.4663 17.4715 21.4897H17.5316C17.9274 20.4657 18.5374 19.5387 19.3205 18.7713C20.1164 17.9688 21.0632 17.3328 22.1059 16.9004" stroke="#082C36" stroke-miterlimit="10"/>
                                <path d="M25.8693 20.3091V23.1954C25.8693 24.1697 25.4836 25.1041 24.7969 25.793C24.1102 26.4819 23.1789 26.869 22.2078 26.869H12.7924C11.8213 26.869 10.89 26.4819 10.2033 25.793C9.51663 25.1041 9.13086 24.1697 9.13086 23.1954V20.3091" stroke="#082C36" stroke-miterlimit="10"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_132_349">
                                <rect width="17" height="19" fill="white" transform="translate(9 8)"/>
                                </clipPath>
                                </defs>
                            </svg>
                        </div>
                    : 
                        <svg cursor='pointer'
                            onClick={() => { setFilename(null); setExcelData(null); setDetails(null)}}
                            width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="0.5" width="34" height="34" stroke="#082C36"/>
                            <line x1="13.0498" y1="11.8432" x2="23.6564" y2="22.4498" stroke="black"/>
                            <line x1="12.3427" y1="22.4497" x2="22.9493" y2="11.8431" stroke="black"/>
                        </svg>
                    }

                    <input
                        ref={inputFileRef}
                        style={{display: 'none'}}
                        type="file"
                        id="file"
                        accept={'.xlsx'}
                        onChange={handleChange}
                        />
                </div>
                <p>*Only file .xml</p>
            </div>

            <div className='report-data'>
                <label className='required'>Title</label>
                <input
                    className='report-maker-input'
                    style={{width: '100%'}}
                    placeholder='Title used for the front page'
                    type="text" 
                    value={details?.title}
                    onChange={ e => setDetails({ ...details, title: e.target.value})}
                    />

                <label className='required'>Sub title</label>
                <textarea
                    className='report-maker-input'
                    style={{width: '100%'}}
                    type="text" 
                    placeholder='Sub title figuring in the second page'
                    value={details?.subTitle}
                    onChange={ e => setDetails({ ...details, subTitle: e.target.value})}
                />
                <button 
                    className='report-maker-btn'
                    onClick={goToNext}>NEXT</button>
            </div>
        </div>
    )
}