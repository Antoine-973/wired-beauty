import React, { useState } from 'react';
import Step0 from './Components/Step0/Step0';
import Step1 from './Components/Step1/Step1';
import Step2 from './Components/Step2/Step2';

export default function Container(){
    const [ step, setStep ]                 = useState(0);
    const [ excelData, setExcelData ]       = useState(null);
    const [ configs, setConfigs ]           = useState([]);
    const [ studyInfos, setStudyInfo ]      = useState({});

    const manageStep0 = (data) => {
        let { studyDetails, ...rest} = data;
        setExcelData(rest);
        setStudyInfo(studyDetails);
        setStep(1);
    }

    switch(step){
        case 2:
            return <Step2
                        studyDetails={studyInfos}
                        configs={configs} 
                        excelData={excelData}/>
        case 1:
            return <Step1 
                        cancel={() => { setExcelData(null); setStudyInfo({}); setStep(0); }}
                        data={excelData} 
                        goNext={ data => {setConfigs(data); setStep(2)}}/>
        case 0:
        default:
            return <Step0 goNext={manageStep0} />
    };

}