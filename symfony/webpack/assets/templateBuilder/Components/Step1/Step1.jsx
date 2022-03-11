import React, {useState, useEffect, useRef} from 'react';
import Switch from "react-switch";
import './Step1.scss';

export default function Step1({data, goNext, cancel}){
    const [ columns, setColumns ]           = useState([null, null, null]);
    const [ selected, setSelected ]         = useState([]);
    const [ advancedMode, setAdvancedMode ] = useState(false);
    const [ setups, setSetups ]             = useState([]);
    const [ details, setDetails ]           = useState({});
    const titleRef = useRef();
    const descriptionRef = useRef();

    const newGraph = () => {
        try{
            if(advancedMode){
                if(selected.indexOf(null) !== -1) throw new Error('Third param missing');
            }else{
                if(selected[0] === null || selected[1] === null) throw new Error('Missing param(s)');
            }
            let tmpSetups = [...setups, {columns: selected, advancedMode, details}];
            titleRef.current.value="";
            descriptionRef.current.value="";
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
        <div className='report-step-1'>
            <h3>What graphics do you want to create ?</h3>
            <label className='required'>Graphic title</label>
            <input
                className='report-maker-input'
                placeholder='Graphic title'
                value={details?.title}
                ref={titleRef}
                onChange={e => setDetails({ ...details, title: e.target.value})}
                type="text" />
            <label>Description</label>
            <textarea
                className='report-maker-input'
                placeholder='Some description'
                value={details?.description}
                ref={descriptionRef}
                onChange={e => setDetails({ ...details, description: e.target.value})}
                type="text" />

            <div className='report-step-1-switch'>
                <span>Use 3 parameters</span>
                <Switch
                    offColor={'#13667A'}
                    onColor={'#13667A'}
                    height={16}
                    width={33}
                    onChange={() => setAdvancedMode(!advancedMode)} 
                    checked={advancedMode} />
            </div>
            
                
            <label>Select which column contains what you want to put in X AXIS</label>
            { columns.length > 0 && 
                <select defaultValue={-1}
                        className='report-maker-input'
                        value={selected[0]} 
                        onChange={e => selectCol(e.target.value, 0)}>
                    <option value={-1} disabled>X Axis</option>
                    {columns.map((col, idx) => <option disabled={idx === selected[1]} key={idx} value={idx}>{col}</option>)}
                </select>
            }

            { (selected[0] !== null && selected[0] !== undefined) && 
                <>
                    <label>Y AXIS is</label>
                    <select defaultValue={-1} 
                        className='report-maker-input'
                        value={selected[1]} 
                        onChange={e => selectCol(e.target.value, 1)}>
                        <option value={-1} disabled>Y Axis</option>
                        {columns.map((col, idx) => <option disabled={idx === selected[0]} key={idx} value={idx}>{col}</option>)}
                    </select>
                </>
            }

            { advancedMode && (selected[1] !== null && selected[1] !== undefined) && 
                <>
                    <label>Filter with</label>
                    <select defaultValue={-1}
                        className='report-maker-input'
                        value={selected[2]} 
                        onChange={e => selectCol(e.target.value, 2)}>
                        <option value={-1} disabled>Filter</option>
                        {columns.map((col, idx) => <option disabled={selected.includes(idx)} key={idx} value={idx}>{col}</option>)}
                    </select>
                </>
            }

            <div className='report-step-1-buttons'>
                <button 
                    className='report-maker-btn-empty'
                    onClick={cancel}>CANCEL</button>
                <button 
                    className='report-maker-btn-empty'
                    onClick={newGraph}>ADD ANOTHER ONE</button>
                <button
                    className='report-maker-btn'
                    onClick={goToNext}>NEXT</button>
            </div>
        </div>
    )
}