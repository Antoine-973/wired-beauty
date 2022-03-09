import react, { useEffect, useState} from 'react';
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from "recharts";

const COLORS = [
    '#c96226', '#8884d8', '#3b9bdb', '#72db90'
];

export default function GraphItem({data, productsList}){
    const [toDisplay, setToDisplay] = useState([]);
  
    useEffect(()=>{
      let tmpData = Object.keys(data).map(prodKey => {
        return Object.keys(data[prodKey]).map( rowKey => {
          return {
            product: productsList[prodKey],
            time: rowKey.length > 15 ? `${rowKey.slice(0, 15)}...` : rowKey , 
            value: parseFloat(data[prodKey][rowKey]),
          }
        })
      });
      setToDisplay(tmpData);
    }, [data]);
  
    return(
        <div style={{ width: '500px'}}>
        <ResponsiveContainer height='100%' width='100%' aspect={1/0.5}>
            <LineChart margin={{ top: 5, right: 20, bottom: 5, left: 0 }} >
            <XAxis allowDuplicatedCategory={false} dataKey={"time"}/>
            <YAxis allowDuplicatedCategories={false} />
            <CartesianGrid strokeDasharray="3 3"/>
            <Tooltip/>
            <Legend />
            { toDisplay.length > 0 &&
                toDisplay.map( (prod, idx) => 
                <Line
                    key={idx}
                    name={prod[0] && prod[0].product}
                    data={prod} 
                    type="monotone"
                    dataKey="value"
                    stroke={`${COLORS[idx%COLORS.length]}`}
                    activeDot={{r: 8}}/>
                )
            }
            </LineChart>
        </ResponsiveContainer>
      </div>
    )
};
