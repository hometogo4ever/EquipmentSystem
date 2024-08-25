const fileServerHost = "https://api.nova.snuaaa.net:9887/fileServer";

async function uploadFile(file, handlers={}){
    const {onUpdate, onFinish, onError} = (
        (handlers)=>{
            const {onUpdate, onFinish, onError} = handlers;
            return {
                onUpdate: (onUpdate instanceof Function)?onUpdate:()=>{},
                onFinish: (onFinish instanceof Function)?onFinish:()=>{},
                onError: (onError instanceof Function)?onError:()=>{}
            }
        }
    )(handlers);

    try{
        onUpdate("파일 생성 중");
    
        const {key, partData, fileSize} = await fetch(
            `${fileServerHost}/file/createFile`,
            {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(
                    {
                        fileName: file.name,
                        fileSize: file.size
                    }
                )
            }
        ).then(res=>res.json());
    
        onUpdate("파일 생성 완료");
    
        const sliceData = partData.reduce(
            ({sliceData, offset}, partSize)=>{
                return {
                    sliceData: [...sliceData, {
                        start: offset,
                        end: offset+partSize
                    }],
                    offset: offset+partSize
                }
            },
            {
                sliceData: [],
                offset: 0
            }
        ).sliceData;
        
        onUpdate("업로드 시작");
        let uploadState = Array.from({length: sliceData.length}).fill(false);
        const uploadPromises = sliceData.map(
            async ({start, end}, index)=>{
                const part = file.slice(start, end);
                const formData = new FormData();
                formData.append("key", key);
                formData.append("partNo", index);
                formData.append("part", part, `${index}.part`);
                const {uploaded, error} = await new Promise(
                    (resolve, reject)=>{
                        
                        $.ajax(
                            {
                                url: `${fileServerHost}/file/uploadPart`,
                                type: "post",
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: formData,
                                success: (data)=>{
                                    resolve(data);
                                },
                                error: (error)=>{
                                    reject(error);
                                }
                            }
                        )
                    }
                );
                if(error){
                    throw error;
                }
                uploadState[index]=(uploaded[index]===0);
                const complete = uploadState.reduce(
                    (result, complete)=>result+complete, 0
                );
                onUpdate(`업로드 중 ${complete}/${uploadState.length}`);
            }
        )
        await Promise.all(uploadPromises);

        onUpdate("파일 합성 중");
        const {fileName: compeleteFileName, ok} = await new Promise(
            (resolve, reject)=>{
                $.ajax(
                    {
                        url: `${fileServerHost}/file/composeFile`,
                        type: "post",
                        contentType: "application/json",
                        data: JSON.stringify({
                            key: key
                        }),
                        success: (data)=>resolve(data),
                        error: (error)=>reject(error)
                    }
                )
            }
        );
        
        onUpdate("파일 업로드 완료");

        onFinish(`${fileServerHost}/file/static/${compeleteFileName}`);
    }
    catch(error){
        onError(error);
    }
}

export default uploadFile;