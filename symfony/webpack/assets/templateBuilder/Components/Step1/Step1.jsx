import React, {useState, useEffect} from 'react';
import Switch from "react-switch";

export default function Step1({data, goNext}){
    const [ columns, setColumns ]           = useState([null, null, null]);
    const [ selected, setSelected ]         = useState([]);
    const [ advancedMode, setAdvancedMode ] = useState(false);
    const [ setups, setSetups ]             = useState([]);
    const [ details, setDetails ]           = useState({});

    const newGraph = () => {
        try{
            if(advancedMode){
                if(selected.indexOf(null) !== -1) throw new Error('Third param missing');
            }else{
                if(selected[0] === null || selected[1] === null) throw new Error('Missing param(s)');
            }
            let tmpSetups = [...setups, {columns: selected, advancedMode, details}];
            setSetups(tmpSetups);
            setSelected([null, null, null]);
            setAdvancedMode(false);
            setDetails({});
        }catch(e){
            console.error(e);
            return;
        }
    };

    const goToNext = () => {
        if(advancedMode){
            if(selected.indexOf(null) !== -1) return
        }else{
            if(selected[0] === null || selected[1] === null) return;
        }
        let tmpSetups = [...setups, {columns: selected, advancedMode, details}];
        setSetups(tmpSetups);
        goNext(tmpSetups);
    };

    const selectCol = (col, idx) => {
        let tmpSelected = [...selected]; 
        tmpSelected[idx] = parseInt(col); 
        setSelected(tmpSelected);
    };

    const getColumns = () => {
        let cols = data.rawData[0];
        setColumns(cols);
    };

    useEffect(()=>{
        if(!advancedMode){
            selectCol(null, 2);
        }
    }, [advancedMode]);

    useEffect(() => {
        getColumns();
    }, [data])

    return(
        <div style={{display: 'flex', flexDirection: 'column', width: '30%'}}>
            <h3>What graphics do you want to create ?</h3>
            <input
                placeholder='Graphic title'
                value={details?.title}
                onChange={e => setDetails({ ...details, title: e.target.value})}
                type="text" />
            <textarea
                placeholder='Some description'
                value={details?.description}
                onChange={e => setDetails({ ...details, description: e.target.value})}
                type="text" />
            <label>
                <span>Use 3 parameters</span>
                <Switch
                    height={16}
                    width={33}
                    onChange={() => setAdvancedMode(!advancedMode)} 
                    checked={advancedMode} />
            </label>
            
                
            <p>Select which column contains what you want to put in X AXIS</p>
            { columns.length > 0 && 
                <select defaultValue={-1} 
                        value={selected[0]} 
                        onChange={e => selectCol(e.target.value, 0)}>
                    <option value={-1} disabled>X Axis</option>
                    {columns.map((col, idx) => <option disabled={idx === selected[1]} key={idx} value={idx}>{col}</option>)}
                </select>
            }

            { (selected[0] !== null && selected[0] !== undefined) && 
                <>
                    <p>Y AXIS is</p>
                    <select defaultValue={-1} 
                        value={selected[1]} 
                        onChange={e => selectCol(e.target.value, 1)}>
                        <option value={-1} disabled>Y Axis</option>
                        {columns.map((col, idx) => <option disabled={idx === selected[0]} key={idx} value={idx}>{col}</option>)}
                    </select>
                </>
            }

            { advancedMode && (selected[1] !== null && selected[1] !== undefined) && 
                <>
                    <p>Filter with</p>
                    <select defaultValue={-1}
                        value={selected[2]} 
                        onChange={e => selectCol(e.target.value, 2)}>
                        <option value={-1} disabled>Filter</option>
                        {columns.map((col, idx) => <option disabled={selected.includes(idx)} key={idx} value={idx}>{col}</option>)}
                    </select>
                </>
            }
            <div style={{marginTop: '10px'}}>
                <button onClick={goToNext}>Ok</button>
                <button onClick={newGraph}>Add another one</button>
            </div>
        </div>
    )
}