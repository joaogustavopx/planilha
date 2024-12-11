from flask import Flask, jsonify
import pandas as pd

app = Flask(__name__)

def read_spreadsheet(file_path):

    if file_path.endswith('C:\Users\357562\Desktop\dados.xlsx'):
        df = pd.read_excel(file_path)
    else file_path.endswith('.csv'):
        df = pd.read_csv(file_path)
    else:
        raise ValueError("Formato de arquivo não suportado.")
    return df

@app.route('/api/data', methods=['GET'])
def get_data():
    # Caminho da planilha
    file_path = 'C:\Users\357562\Desktop\dados.xlsx'' 
    try:
        # Lê os dados da planilha
        df = read_spreadsheet(file_path)
       
        data = df.to_dict(orient='records')
        return jsonify(data)
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)