import pandas as pd
import json
from pandas import compat

#rating = pd.read_csv('movie_rating(1).csv')
rating = pd.read_json('http://localhost/rekomen/api/index.php/daftar_nilai')
rp = rating.pivot_table(columns=['id_mahasiswa'],index=['nama_matkul'],values='nilai_mahasiswa')

def to_dict_dropna(rp):
   return {(k): v.dropna().astype(int).to_dict() for k, v in compat.iteritems(rp)}

dataset=to_dict_dropna(rp)
#json = rp.dropna().astype(int).to_json()
#json = enco.to_json()
#dataset = str(dataset)
#print dataset