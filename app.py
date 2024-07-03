import pandas as pd
from sklearn.linear_model import LogisticRegression
from sklearn import preprocessing
import logging
from statistics import mode

# Set up logging
logging.basicConfig(filename='./app.log', filemode='w', level=logging.INFO, format='%(asctime)s - %(message)s')

# Read the data from CSV
data_file = '/home/iszoharsw/public_html/new/DataVolunteer.csv'
df = pd.read_csv(data_file)

# Encode categorical columns: 'KindOfHelp', 'NeedyCity', 'DayInWeek'
le_help = preprocessing.LabelEncoder()
df['KindOfHelp_encoded'] = le_help.fit_transform(df['KindOfHelp'])

le_city = preprocessing.LabelEncoder()
df['NeedyCity_encoded'] = le_city.fit_transform(df['NeedyCity'])

le_day = preprocessing.LabelEncoder()
df['DayInWeek_encoded'] = le_day.fit_transform(df['DayInWeek'])

def train_and_predict(features, labels, le, col_name):
    if len(set(labels)) > 1:
        clf = LogisticRegression(random_state=1234, max_iter=1000, C=10, penalty='l1', solver='liblinear')
        clf.fit(features, labels)
        predictions = clf.predict(features)
        df[f'Predicted{col_name}_encoded'] = predictions
        df[f'Predicted{col_name}'] = le.inverse_transform(predictions)
        logging.info(f'Successfully predicted {col_name}')
        return predictions
    else:
        df[f'Predicted{col_name}_encoded'] = labels
        df[f'Predicted{col_name}'] = le.inverse_transform(labels)
        logging.warning(f'Not enough classes to train {col_name}')
        return labels

# Prepare features and labels for 'KindOfHelp' prediction
features_help = df[['NeedyCity_encoded', 'DayInWeek_encoded']]
labels_help = df['KindOfHelp_encoded']
predicted_help = train_and_predict(features_help, labels_help, le_help, 'KindOfHelp')

# Prepare features and labels for 'NeedyCity' prediction
features_city = df[['KindOfHelp_encoded', 'DayInWeek_encoded']]
labels_city = df['NeedyCity_encoded']
predicted_city = train_and_predict(features_city, labels_city, le_city, 'NeedyCity')

# Prepare features and labels for 'DayInWeek' prediction
features_day = df[['KindOfHelp_encoded', 'NeedyCity_encoded']]
labels_day = df['DayInWeek_encoded']
predicted_day = train_and_predict(features_day, labels_day, le_day, 'DayInWeek')

# Function to find most common value in a column
def find_most_common(column):
    most_common_value = mode(column)
    return most_common_value

# Find most common values for each predicted column
most_common_help = find_most_common(df['PredictedKindOfHelp'])
most_common_city = find_most_common(df['PredictedNeedyCity'])
most_common_day = find_most_common(df['PredictedDayInWeek'])

# Create a DataFrame with the most common predictions
most_common_data = {
    'PredictedKindOfHelp': [most_common_help],
    'PredictedNeedyCity': [most_common_city],
    'PredictedDayInWeek': [most_common_day]
}
most_common_df = pd.DataFrame(most_common_data)

# Save the most common predictions to a new CSV file
output_file = '/home/iszoharsw/public_html/new/Predict.csv'
most_common_df.to_csv(output_file, index=False)
print("Success")
