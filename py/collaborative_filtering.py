
#!/usr/bin/env python
# Implementation of collaborative filtering recommendation engine

import numpy as np
from recommendation_data import dataset
from math import sqrt
import json
import sys
import MySQLdb

def similarity_score(person1,person2):
	
	# Returns ratio Euclidean distance score of person1 and person2 

	both_viewed = {}		# To get both rated items by person1 and person2

	for item in dataset[person1]:
		if item in dataset[person2]:
			both_viewed[item] = 1

		# Conditions to check they both have an common rating items	
		if len(both_viewed) == 0:
			return 0

		# Finding Euclidean distance 
		sum_of_eclidean_distance = []	

		for item in dataset[person1]:
			if item in dataset[person2]:
				sum_of_eclidean_distance.append(pow(dataset[person1][item] - dataset[person2][item],2))
		sum_of_eclidean_distance = sum(sum_of_eclidean_distance)

		return 1/(1+sqrt(sum_of_eclidean_distance))



def pearson_correlation(person1,person2):

	# To get both rated items
	both_rated = {}
	for item in dataset[person1]:
		if item in dataset[person2]:
			both_rated[item] = 1

	number_of_ratings = len(both_rated)		
	
	# Checking for number of ratings in common
	if number_of_ratings == 0:
		return 0

	# Add up all the preferences of each user
	person1_preferences_sum = sum([dataset[person1][item] for item in both_rated])
	person2_preferences_sum = sum([dataset[person2][item] for item in both_rated])

	# Sum up the squares of preferences of each user
	person1_square_preferences_sum = sum([pow(dataset[person1][item],2) for item in both_rated])
	person2_square_preferences_sum = sum([pow(dataset[person2][item],2) for item in both_rated])

	# Sum up the product value of both preferences for each item
	product_sum_of_both_users = sum([dataset[person1][item] * dataset[person2][item] for item in both_rated])

	# Calculate the pearson score
	numerator_value = product_sum_of_both_users - (person1_preferences_sum*person2_preferences_sum/number_of_ratings)
	denominator_value = sqrt((person1_square_preferences_sum - pow(person1_preferences_sum,2)/number_of_ratings) * (person2_square_preferences_sum -pow(person2_preferences_sum,2)/number_of_ratings))
	if denominator_value == 0:
		return 0
	else:
		r = numerator_value/denominator_value
		return r 

def most_similar_users(person,number_of_users):
	# returns the number_of_users (similar persons) for a given specific person.
	scores = [(pearson_correlation(person,other_person),other_person) for other_person in dataset if  other_person != person ]
	
	# Sort the similar persons so that highest scores person will appear at the first
	scores.sort()
	scores.reverse()
	return scores[0:number_of_users]

def user_reommendations(person):

	# Gets recommendations for a person by using a weighted average of every other user's rankings
	totals = {}
	simSums = {}
	rankings_list =[]
	for other in dataset:
		# don't compare me to myself
		if other == person:
			continue
		sim = pearson_correlation(person,other)
		#print ">>>>>>>",sim

		# ignore scores of zero or lower
		if sim <=0: 
			continue
		for item in dataset[other]:

			# only score movies i haven't seen yet
			if item not in dataset[person] or dataset[person][item] == 0:

			# Similrity * score
				totals.setdefault(item,0)
				totals[item] += dataset[other][item]* sim
				# sum of similarities
				simSums.setdefault(item,0)
				simSums[item]+= sim

		# Create the normalized list

	rankings = [(total/simSums[item],item) for item,total in totals.items()]
	rankings.sort()
	rankings.reverse()
	# returns the recommended items
	recommendataions_list = [recommend_item for score,recommend_item in rankings]
	return recommendataions_list
#output nilai	
#user = raw_input("Masukan Nama: ")	
user = sys.argv[1]
user = int(user)
varlist = user_reommendations(user)
#b = most_similar_users(user,2)
#rows = []

print 'rekomendasi',user,'adalah',varlist
campur=[user]*len(varlist)
#update kirim data new......... machine learning v0.02
#make json dumps
#def json_list2(list2,list1):
#    lst = []
#    for pn in list2:
#		d = {}
#		d['matkul']=pn
#		for npn in list1:
#lst.append(d)
	#for npn in list1:
			#r = {}
#			d['nama	']=npn
			#lst.append(r)
#		lst.append(d)
 #   return json.dumps(lst)

#jsonjadi2 = json_list2(varlist,campur) 
#update machine learning v0.03
#insert many db + input: python nama.py input
datacampur = zip(campur,varlist)
db = MySQLdb.connect(host="localhost", user="root", passwd="",db="rekomendasi")
cursor = db.cursor()

#sql = "INSERT INTO `rekomendasi`.`nilai_rekomendasi` (`nama`, `rekomendasi`) VALUES ( '"+user+"','"+varlist[0]+"');"
cursor.executemany('''insert into dummy_reko (nama, rekomendasi)
                      values (%s, %s)''', datacampur)

#cursor.execute(sql)
db.commit()

db.close()
#print pearson_correlation('Lisa Rose','Gene Seymour') 